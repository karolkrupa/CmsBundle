<?php

namespace Devster\CmsBundle\Crud;

use Symfony\Component\HttpFoundation\Response;

interface PageHandlerInterface
{
    /**
     * Handles the view and returns http response
     *
     * @param PageInterface $page
     * @param PagePayloadInterface $payload
     * @return Response
     */
    public function handle(PageInterface $page, PagePayloadInterface $payload): Response;
}