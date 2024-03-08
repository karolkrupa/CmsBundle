<?php

namespace Devster\CmsBundle\Crud\List;

use Devster\CmsBundle\Crud\PageHandlerInterface;
use Devster\CmsBundle\Crud\PageInterface;
use Devster\CmsBundle\Crud\PagePayloadInterface;
use Symfony\Component\HttpFoundation\Response;

class ListPage implements PageInterface
{
    public function __construct(
        protected readonly ListPageConfig       $config,
        protected readonly PageHandlerInterface $handler
    )
    {
    }

    public function response(PagePayloadInterface $payload): Response
    {
        return $this->handler->handle($this, $payload);
    }

    public function getPageConfig(): ListPageConfig
    {
        return $this->config;
    }
}