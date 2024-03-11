<?php

namespace Devster\CmsBundle\Crud\Common\TemplatePage;

use Devster\CmsBundle\Crud\AbstractPageHandler;
use Devster\CmsBundle\Crud\Common\View\TemplatePageViewContext;
use Devster\CmsBundle\Crud\PageInterface;
use Devster\CmsBundle\Crud\PagePayloadInterface;
use Symfony\Component\HttpFoundation\Response;

class TemplatePageHandler extends AbstractPageHandler
{
    public function handle(PageInterface $page, PagePayloadInterface $payload): Response
    {
        if (!$page instanceof TemplatePage) {
            throw new \RuntimeException('Niepoprawny typ widoku');
        }

        if (!$payload instanceof TemplatePagePayload) {
            throw new \RuntimeException('Niepoprawny payload');
        }

        $view = $page->getPageConfig()->getView();

        return new Response(
            $this->getRenderer($view->getRenderer())->render($view, $payload, new TemplatePageViewContext())
        );
    }
}