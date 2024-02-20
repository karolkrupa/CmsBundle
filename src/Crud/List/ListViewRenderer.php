<?php

namespace Devster\CmsBundle\Crud\List;

use Devster\CmsBundle\Crud\Common\PageRendererInterface;
use Devster\CmsBundle\Crud\Common\PageViewInterface;
use Devster\CmsBundle\Crud\Edit\EditView;
use Devster\CmsBundle\Crud\List\Action\ActionRenderInterface;
use Devster\CmsBundle\Crud\List\FilterForm\FilterFormRenderer;
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

class ListViewRenderer implements PageRendererInterface
{
    protected PaginationSettings $pagination;

    public function __construct(
        private readonly Environment        $twig,
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
        $this->pagination = new PaginationSettings();
    }

    public function pagination(): PaginationSettings
    {
        return $this->pagination;
    }

    public function render(PageViewInterface $view, mixed $data): string
    {
        if (!$view instanceof EditView) {
            throw new \LogicException('Oczekiwany typ: ' . ListView::class);
        }

        return $this->renderIterableData($view, $data);
    }

    public function renderQbData(ListView $view, QueryBuilder $qb)
    {
        $pagination = $this->getPagination($qb);

        return $this->renderIterableData($view, $pagination, $pagination);
    }

    private function renderIterableData(ListView $view, iterable $data, mixed $pagination = null)
    {
        $headings = [];
        $rows = [];

        foreach ($view->getFields() as $field) {
            $renderer = $this->headingRendererLocator->get($field->getHeading()->getRenderer());
            $html = $this->twig->render(
                '@DevsterCms/crud/list/heading/heading.html.twig',
                [
                    'heading' => $field->getHeading(),
                    'headingHtml' => $renderer->render($field->getHeading(), $pagination)
                ]
            );
            $headings[] = new Markup($html, 'UTF-8');
        }

        foreach ($data as $rowData) {
            $rowCells = [];
            foreach ($view->getFields() as $field) {
                $renderer = $this->cellRendererLocator->get($field->getCell()->getRenderer());
                $html = $this->twig->render(
                    '@DevsterCms/crud/list/cell/cell.html.twig',
                    [
                        'cell' => $field->getCell(),
                        'cellHtml' => $renderer->render($field->getCell(), $rowData)
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

            $pageActionViews[] = $renderer->renderPageView($action);
        }

        return $this->twig->render('@DevsterCms/crud/list/view.html.twig', [
            'pageTitle' => $view->title,
            'headings' => $headings,
            'rows' => $rows,
            'pagination' => $pagination,
            'filterFormView' => $filterFormView['form'],
            'filterFormControlsView' => $filterFormView['controls'],
            'pageActionViews' => $pageActionViews
        ]);
    }

    private function getPagination(QueryBuilder $qb): PaginationInterface
    {
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
                $this->pagination->pageParam,
                1
            ),
            $this->pagination->itemsPerPage,
            [
                'pageParameterName' => $this->pagination->pageParam,
                'sortFieldParameterName' => $this->pagination->sortParam,
                'sortDirectionParameterName' => $this->pagination->sortDirectionParam,
                'defaultSortFieldName' => $this->pagination->defaultSortField,
                'defaultSortDirection' => $this->pagination->defaultSortFieldDirection
            ]
        );

        $pagination->renderer = function ($data) use ($request) {
            return $this->twig->render(
                '@DevsterCms/crud/list/pagination.html.twig',
                [
                    ...$data,
                    ...[
                        'route' => 'app_test_test',
                        'query' => $request->query->all()
                    ]
                ]
            );
        };

        return $pagination;
    }
}