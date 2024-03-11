<?php

namespace Devster\CmsBundle\Crud\Delete;

class DeletePageEvent
{
    public function __construct(
        private readonly mixed      $data,
        private readonly DeletePage $page
    )
    {
    }

    public function getData(): mixed
    {
        return $this->data;
    }

    public function getPage(): DeletePage
    {
        return $this->page;
    }
}