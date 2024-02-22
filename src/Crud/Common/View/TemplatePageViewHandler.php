<?php

namespace Devster\CmsBundle\Crud\Common\View;

use Symfony\Component\HttpFoundation\Response;

class TemplatePageViewHandler extends AbstractPageViewHandler
{
    public function handle(PageViewInterface $view, PageViewPayloadInterface $payload): Response
    {
        $renderer = $this->getRenderer($view->getRenderer());

        return new Response(
            $renderer->render($view, $payload)
        );
    }
}