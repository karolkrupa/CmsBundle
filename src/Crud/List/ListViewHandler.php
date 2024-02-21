<?php

namespace Devster\CmsBundle\Crud\List;

use Devster\CmsBundle\Crud\List\FilterForm\FilterFormHandler;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\HttpFoundation\Response;

class ListViewHandler
{
    public function __construct(
        private readonly FilterFormHandler $filterFormHandler,
        private readonly ListViewRenderer  $listViewRenderer
    )
    {
    }

    public function handle(ListView $listView, QueryBuilder $qb, ?string $rootAlias = null): Response
    {
        if (!$rootAlias && !empty($qb->getRootAliases())) {
            $rootAlias = $qb->getRootAliases()[0];
        }

        if ($filterForm = $listView->getFilterForm()) {
            $this->filterFormHandler->handle($filterForm, $qb, $rootAlias);
        }

        return new Response(
            $this->listViewRenderer->renderQbData(
                $listView,
                $qb,
                $rootAlias,
                $listView->getPagination()
            )
        );
    }
}