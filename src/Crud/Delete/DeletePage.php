<?php

namespace Devster\CmsBundle\Crud\Delete;

use Devster\CmsBundle\Crud\PageHandlerInterface;
use Devster\CmsBundle\Crud\PageInterface;
use Devster\CmsBundle\Crud\PagePayloadInterface;
use Symfony\Component\HttpFoundation\Response;

class DeletePage implements PageInterface
{
    public function __construct(
        protected readonly DeletePageConfig     $config,
        protected readonly PageHandlerInterface $handler
    )
    {
    }

    public function response(PagePayloadInterface $payload): Response
    {
        return $this->handler->handle($this, $payload);
    }

    public function getPageConfig(): DeletePageConfig
    {
        return $this->config;
    }
}