<?php

namespace Devster\CmsBundle\Crud\Common\View\Handler;

use Devster\CmsBundle\Crud\Common\View\PageViewInterface;
use Devster\CmsBundle\Crud\Common\View\PageViewPayloadInterface;
use Devster\CmsBundle\Crud\Common\View\TemplatePageViewContext;
use Symfony\Component\HttpFoundation\Response;

/**
 * Handler form template page view
 */
class TemplatePageViewHandler extends AbstractPageViewHandler
{
    public function handle(PageViewInterface $view, PageViewPayloadInterface $payload): Response
    {
        $renderer = $this->getRenderer($view->getRenderer());

        return new Response(
            $renderer->render($view, $payload, new TemplatePageViewContext())
        );
    }
}