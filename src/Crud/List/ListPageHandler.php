<?php

namespace Devster\CmsBundle\Crud\List;

use Devster\CmsBundle\Crud\AbstractPageHandler;
use Devster\CmsBundle\Crud\List\FilterForm\FilterFormHandler;
use Devster\CmsBundle\Crud\List\Renderer\ListPageViewRenderer;
use Devster\CmsBundle\Crud\PageInterface;
use Devster\CmsBundle\Crud\PagePayloadInterface;
use Symfony\Component\HttpFoundation\Response;

class ListPageHandler extends AbstractPageHandler
{
    public function __construct(
        private readonly FilterFormHandler $filterFormHandler,
        private readonly ListPageViewRenderer $listViewRenderer
    )
    {
    }

    public function handle(PageInterface $page, PagePayloadInterface $payload): Response
    {
        if(!$page instanceof ListPage) {
            throw new \RuntimeException('Nieobsługiwany typ widoku. przekazany: '. get_class($view));
        }

        if(!$payload instanceof ListPagePayload) {
            throw new \RuntimeException('Nieobsługiwany typ paylad. przekazany: '. get_class($payload));
        }

        $view = $page->getPageConfig()->getView();
        $rootAlias = $payload->rootAlias;
        if (!$rootAlias && !empty($payload->qb->getRootAliases())) {
            $rootAlias = $payload->qb->getRootAliases()[0];
        }

        $filterData = [];
        if ($filterForm = $view->getFilterForm()) {
            $filterData = $this->filterFormHandler->handle($filterForm, $payload->qb, $rootAlias);
        }

        return new Response(
            $this->listViewRenderer->renderQbData(
                $view,
                $payload->qb,
                new ListPageViewContext($filterData),
                $rootAlias,
                $view->getPagination()
            )
        );
    }
}