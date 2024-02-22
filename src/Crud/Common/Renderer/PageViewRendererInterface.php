<?php

namespace Devster\CmsBundle\Crud\Common\Renderer;

use Devster\CmsBundle\Crud\Common\View\PageViewInterface;
use Devster\CmsBundle\Crud\Common\View\PageViewPayloadInterface;
use Twig\Markup;

interface PageViewRendererInterface
{
    public function render(PageViewInterface $view, PageViewPayloadInterface $payload): string;
}