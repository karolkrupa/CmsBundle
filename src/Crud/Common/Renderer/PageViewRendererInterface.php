<?php

namespace Devster\CmsBundle\Crud\Common\Renderer;

use Devster\CmsBundle\Crud\Common\View\PageViewInterface;
use Devster\CmsBundle\Crud\Common\View\PageViewPayloadInterface;
use Twig\Markup;

interface PageViewRendererInterface
{
    /**
     * Renders the page view and returns HTML string
     *
     * @param PageViewInterface $view
     * @param PageViewPayloadInterface $payload
     * @return string
     */
    public function render(PageViewInterface $view, PageViewPayloadInterface $payload): string;
}