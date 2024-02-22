<?php

namespace Devster\CmsBundle\Crud\Common\View;

use Symfony\Component\HttpFoundation\Response;

interface PageViewHandlerInterface
{
    public function handle(PageViewInterface $view, PageViewPayloadInterface $payload): Response;
}