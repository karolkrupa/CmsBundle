<?php

namespace Devster\CmsBundle\Crud\List;

use Devster\CmsBundle\Crud\Common\View\PageViewPayloadInterface;
use Doctrine\ORM\QueryBuilder;

class ListPageViewPayload implements PageViewPayloadInterface
{
    public function __construct(
        public readonly QueryBuilder $qb,
        public readonly ?string      $rootAlias = null
    )
    {
    }

    /**
     * @return object{qb: QueryBuilder, rootAlias: null|string}
     */
    public function getPayload(): object
    {
        return (object)[
            'qb' => $this->qb,
            'rootAlias' => $this->rootAlias
        ];
    }
}