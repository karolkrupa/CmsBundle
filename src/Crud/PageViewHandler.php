<?php

namespace Devster\CmsBundle\Crud;

use Devster\CmsBundle\Crud\Common\View\PageViewInterface;
use Devster\CmsBundle\Crud\Common\View\Handler\PageViewHandlerInterface;
use Devster\CmsBundle\Crud\Common\View\PageViewPayloadInterface;
use Symfony\Component\DependencyInjection\Attribute\TaggedLocator;
use Symfony\Component\DependencyInjection\ServiceLocator;
use Symfony\Component\HttpFoundation\Response;

/** @deprecated  */
class PageViewHandler
{
    public function __construct(
        #[TaggedLocator('devster.cms.view.handler')]
        private readonly ServiceLocator $handlers
    )
    {
    }

    public function response(PageViewInterface $view, PageViewPayloadInterface $payload): Response
    {
        /** @var PageViewHandlerInterface $handler */
        $handler = $this->handlers->get($view->getHandler());

        return $handler->handle($view, $payload);
    }
}