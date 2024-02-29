<?php

namespace Devster\CmsBundle\Crud\List;

use Devster\CmsBundle\Crud\Common\View\PageViewContextInterface;

class ListPageViewContext implements PageViewContextInterface
{
    public function __construct(
        private readonly array $filterData
    )
    {
    }

    public function getFilterData(): array
    {
        return $this->filterData;
    }
}