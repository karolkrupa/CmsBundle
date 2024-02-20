<?php

namespace Devster\CmsBundle\Crud\List\Pagination;

class PaginationSettings
{
    public int $itemsPerPage = 10;
    public string $pageParam = 'page';
    public string $sortParam = 'sort';
    public string $sortDirectionParam = 'direction';
    public ?string $defaultSortField = null;
    public ?string $defaultSortFieldDirection = 'asc';

    public function pageParam(string $param = 'page'): self
    {
        $this->pageParam = $param;

        return $this;
    }

    public function sortParam(string $param = 'sort'): self
    {
        $this->sortParam = $param;

        return $this;
    }

    public function sortDirectionParam(string $param = 'direction'): self
    {
        $this->sortDirectionParam = $param;

        return $this;
    }

    public function itemsPerPage(int $itemsPerPage = 10): self
    {
        $this->itemsPerPage = $itemsPerPage;

        return $this;
    }

    public function defaultSortField(?string $field = null, string $direction = 'asc'): self
    {
        $this->defaultSortField = $field;
        $this->defaultSortFieldDirection = $direction;

        return $this;
    }
}