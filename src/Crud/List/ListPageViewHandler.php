<?php

namespace Devster\CmsBundle\Crud\List;

use Devster\CmsBundle\Crud\Common\View\PageViewInterface;
use Devster\CmsBundle\Crud\Common\View\PageViewHandlerInterface;
use Devster\CmsBundle\Crud\Common\View\PageViewPayloadInterface;
use Devster\CmsBundle\Crud\List\FilterForm\FilterFormHandler;
use Devster\CmsBundle\Crud\List\Renderer\ListPageViewRenderer;
use Symfony\Component\HttpFoundation\Response;

class ListPageViewHandler implements PageViewHandlerInterface
{
    public function __construct(
        private readonly FilterFormHandler $filterFormHandler,
        private readonly ListPageViewRenderer $listViewRenderer
    )
    {
    }

    public function handle(PageViewInterface $view, PageViewPayloadInterface $payload): Response
    {
        if(!$view instanceof ListPageView) {
            throw new \RuntimeException('Nieobsługiwany typ widoku. przekazany: '. get_class($view));
        }

        if(!$payload instanceof ListPageViewPayload) {
            throw new \RuntimeException('Nieobsługiwany typ paylad. przekazany: '. get_class($payload));
        }

        $rootAlias = $payload->rootAlias;
        if (!$rootAlias && !empty($payload->qb->getRootAliases())) {
            $rootAlias = $payload->qb->getRootAliases()[0];
        }

        if ($filterForm = $view->getFilterForm()) {
            $this->filterFormHandler->handle($filterForm, $payload->qb, $rootAlias);
        }

        return new Response(
            $this->listViewRenderer->renderQbData(
                $view,
                $payload->qb,
                $rootAlias,
                $view->getPagination()
            )
        );
    }
}