<?php

namespace Devster\CmsBundle\Crud\Edit;

use Devster\CmsBundle\Crud\PageHandlerInterface;
use Devster\CmsBundle\Crud\PageInterface;
use Devster\CmsBundle\Crud\PagePayloadInterface;
use Symfony\Component\HttpFoundation\Response;

class EditPage implements PageInterface
{
    public function __construct(
        protected readonly EditPageConfig $pageConfig,
        protected readonly PageHandlerInterface $handler
    )
    {
    }

    public function response(PagePayloadInterface $payload): Response
    {
        return $this->handler->handle($this, $payload);
    }

    public function getPageConfig(): EditPageConfig
    {
        return $this->pageConfig;
    }
}