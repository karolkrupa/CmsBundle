<?php

namespace Devster\CmsBundle\Crud;

use Symfony\Component\HttpFoundation\Response;

interface PageInterface
{
    public function response(PagePayloadInterface $payload): Response;

    public function getPageConfig(): PageConfigInterface;
}