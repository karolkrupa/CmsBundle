<?php

namespace Devster\CmsBundle\Crud\Common\TemplatePage\Renderer;

use Devster\CmsBundle\Crud\Common\View\PageViewContextInterface;
use Devster\CmsBundle\Crud\Common\View\PageViewInterface;
use Devster\CmsBundle\Crud\PagePayloadInterface;
use Twig\Markup;

interface PageViewRendererInterface
{
    /**
     * Renders the page view and returns HTML string
     *
     * @param PageViewInterface $view
     * @param PagePayloadInterface $payload
     * @param PageViewContextInterface $context
     * @return string
     */
    public function render(PageViewInterface $view, PagePayloadInterface $payload, PageViewContextInterface $context): string;
}