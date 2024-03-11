<?php

namespace Devster\CmsBundle\Crud\Common\Page;

use Devster\CmsBundle\Crud\PageInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class PageResultUrlHandler implements PageResultHandlerInterface
{
    public function __construct(
        protected string $url
    )
    {
    }

    public function handle(UrlGeneratorInterface $urlGenerator, PageInterface $page, mixed $data): RedirectResponse
    {
        return new RedirectResponse($this->url);
    }
}