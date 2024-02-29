<?php

namespace Devster\CmsBundle\Crud\List\Renderer;

use Devster\CmsBundle\Crud\Common\View\Renderer\PageViewRendererInterface;
use Devster\CmsBundle\Crud\Common\View\Renderer\TemplatePageViewRenderer;
use Devster\CmsBundle\Crud\Common\View\PageViewContextInterface;
use Devster\CmsBundle\Crud\Common\View\PageViewInterface;
use Devster\CmsBundle\Crud\Common\View\PageViewPayloadInterface;
use Devster\CmsBundle\Crud\Edit\EditView;
use Devster\CmsBundle\Crud\List\Action\Renderer\ActionRenderInterface;
use Devster\CmsBundle\Crud\List\Cell\Renderer\CellRendererInterface;
use Devster\CmsBundle\Crud\List\Cell\TitledCellInterface;
use Devster\CmsBundle\Crud\List\FilterForm\Renderer\FilterFormRenderer;
use Devster\CmsBundle\Crud\List\ListPageView;
use Devster\CmsBundle\Crud\List\ListPageViewPayload;
use Devster\CmsBundle\Crud\List\Pagination\PaginationSettings;
use Devster\CmsBundle\KnpPager\Event\Subscriber\SortableSubscriber;
use Doctrine\ORM\QueryBuilder;
use Knp\Component\Pager\ArgumentAccess\RequestArgumentAccess;
use Knp\Component\Pager\Event\Subscriber\Paginate\PaginationSubscriber;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Symfony\Component\DependencyInjection\Attribute\TaggedLocator;
use Symfony\Component\DependencyInjection\ServiceLocator;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Environment;
use Twig\Markup;

class ListPageViewRenderer extends TemplatePageViewRenderer
{
    public function __construct(
        #[TaggedLocator(tag: 'devster.cms.renderer.heading')]
        private readonly ServiceLocator     $headingRendererLocator,
        #[TaggedLocator(tag: 'devster.cms.renderer.cell')]
        private readonly ServiceLocator     $cellRendererLocator,
        #[TaggedLocator(tag: 'devster.cms.renderer.action')]
        private readonly ServiceLocator     $actionRendererLocator,
        private readonly RequestStack       $requestStack,
        private readonly FilterFormRenderer $filterFormRenderer
    )
    {
    }

    public function render(PageViewInterface $view, PageViewPayloadInterface $payload, PageViewContextInterface $context): string
    {
        if (!$view instanceof EditView) {
            throw new \LogicException('Oczekiwany typ: ' . ListPageView::class);
        }

        if (!$payload instanceof ListPageViewPayload) {
            throw new \LogicException('Oczekiwany typ: ' . ListPageView::class);
        }

        return $this->renderIterableData($view, $payload->getPayload(), $context);
    }

    public function renderQbData(
        ListPageView        $view,
        QueryBuilder        $qb,
        PageViewContextInterface $context,
        ?string             $rootAlias = null,
        ?PaginationSettings $paginationSettings = null
    )
    {
        $pagination = $this->getPagination($qb, $paginationSettings);

        return $this->renderIterableData(
            $view,
            $pagination,
            $context,
            $pagination,
            $rootAlias
        );
    }

    private function renderIterableData(
        ListPageView $view,
        iterable     $data,
        PageViewContextInterface $context,
        mixed        $pagination = null,
        ?string      $rootAlias = null
    )
    {
        $headings = [];
        $rows = [];

        foreach ($view->getFields() as $field) {
            $renderer = $this->headingRendererLocator->get($field->getHeading()->getRenderer());
            $html = $this->twig()->render(
                '@DevsterCms/crud/list/heading/heading.html.twig',
                [
                    'field' => $field,
                    'headingHtml' => $renderer->render(
                        $field,
                        $pagination,
                        $rootAlias
                    )
                ]
            );
            $headings[] = new Markup($html, 'UTF-8');
        }

        foreach ($data as $rowData) {
            $rowCells = [];
            foreach ($view->getFields() as $field) {
                /** @var CellRendererInterface $renderer */
                $renderer = $this->cellRendererLocator->get($field->getCell()->getRenderer());

                $cellTitle = '';
                if ($field->getCell() instanceof TitledCellInterface) {
                    $cellTitle = $field->getCell()->getTitle();

                    if ($cellTitle instanceof \Closure) {
                        $cellTitle = $cellTitle($rowData);
                    }
                }


                $html = $this->twig()->render(
                    '@DevsterCms/crud/list/cell/cell.html.twig',
                    [
                        'field' => $field,
                        'cell' => $field->getCell(),
                        'title' => $cellTitle,
                        'cellHtml' => $renderer->render($field->getCell(), $rowData, $context)
                    ]
                );

                $rowCells[] = new Markup($html, 'UTF-8');
            }

            $rows[] = $rowCells;
        }

        $filterFormView = null;
        if ($view->getFilterForm()) {
            $filterFormView = $this->filterFormRenderer->render($view->getFilterForm());
        }

        $pageActionViews = [];
        foreach ($view->getActions() as $action) {
            /** @var ActionRenderInterface $renderer */
            $renderer = $this->actionRendererLocator->get($action->getRenderer());

            $pageActionViews[] = $renderer->render($action, null);
        }

        // @DevsterCms/crud/list/view.html.twig
        return $this->twig()->render($view->getTemplate(), [
            'pageTitle' => $view->getTitle(),
            'headings' => $headings,
            'rows' => $rows,
            'pagination' => $pagination,
            'filterFormView' => $filterFormView['form'],
            'filterFormControlsView' => $filterFormView['controls'],
            'pageActionViews' => $pageActionViews
        ]);
    }

    private function getPagination(QueryBuilder $qb, ?PaginationSettings $paginationSettings = null): PaginationInterface
    {
        $paginationSettings = $paginationSettings ?: new PaginationSettings();

        $dispatcher = new EventDispatcher();
        $dispatcher->addSubscriber(new PaginationSubscriber());
        $dispatcher->addSubscriber(new SortableSubscriber());

        $paginator = new \Knp\Component\Pager\Paginator(
            $dispatcher,
            new RequestArgumentAccess($this->requestStack)
        );

        $request = $this->requestStack->getCurrentRequest();

        $pagination = $paginator->paginate(
            $qb,
            $request->get(
                $paginationSettings->pageParam,
                1
            ),
            $paginationSettings->itemsPerPage,
            [
                'pageParameterName' => $paginationSettings->pageParam,
                'sortFieldParameterName' => $paginationSettings->sortParam,
                'sortDirectionParameterName' => $paginationSettings->sortDirectionParam,
                'defaultSortFieldName' => $paginationSettings->defaultSortField,
                'defaultSortDirection' => $paginationSettings->defaultSortFieldDirection
            ]
        );

        $pagination->renderer = function ($data) use ($request) {
            return $this->twig()->render(
                '@DevsterCms/crud/list/pagination.html.twig',
                [
                    ...$data,
                    ...[
                        'route' => $this->requestStack->getMainRequest()->attributes->get('_route'),
                        'query' => $request->query->all()
                    ]
                ]
            );
        };

        return $pagination;
    }
}