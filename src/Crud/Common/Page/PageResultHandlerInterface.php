<?php

namespace Devster\CmsBundle\Crud\Common\Page;

use Devster\CmsBundle\Crud\PageInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

interface PageResultHandlerInterface
{
    public function handle(UrlGeneratorInterface $urlGenerator, PageInterface $page, mixed $data): RedirectResponse;
}