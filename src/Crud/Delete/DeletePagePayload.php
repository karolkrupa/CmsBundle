<?php

namespace Devster\CmsBundle\Crud\Delete;

use Devster\CmsBundle\Crud\PagePayloadInterface;

class DeletePagePayload implements PagePayloadInterface
{
    public function __construct(
        protected readonly mixed $entity
    )
    {
    }

    public function getPayload(): mixed
    {
        return $this->entity;
    }
}