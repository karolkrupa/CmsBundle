<?php

namespace Devster\CmsBundle\Crud\Common\TemplatePage;

use Devster\CmsBundle\Crud\PageHandlerInterface;
use Devster\CmsBundle\Crud\PageInterface;
use Devster\CmsBundle\Crud\PagePayloadInterface;
use Symfony\Component\HttpFoundation\Response;

class TemplatePage implements PageInterface
{
    public function __construct(
        protected readonly TemplatePageConfig  $config,
        protected readonly PageHandlerInterface $handler
    )
    {
    }

    public function response(PagePayloadInterface $payload): Response
    {
        return $this->handler->handle($this, $payload);
    }

    public function getPageConfig(): TemplatePageConfig
    {
        return $this->config;
    }
}