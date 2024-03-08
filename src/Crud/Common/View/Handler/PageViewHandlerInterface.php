<?php

namespace Devster\CmsBundle\Crud\Common\View\Handler;

use Devster\CmsBundle\Crud\Common\View\PageViewInterface;
use Devster\CmsBundle\Crud\Common\View\PageViewPayloadInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * @deprecated
 *
 * Interface for page view handlers
 */
interface PageViewHandlerInterface
{
    /**
     * Handles the view and returns http response
     *
     * @param PageViewInterface $view
     * @param PageViewPayloadInterface $payload
     * @return Response
     */
    public function handle(PageViewInterface $view, PageViewPayloadInterface $payload): Response;
}