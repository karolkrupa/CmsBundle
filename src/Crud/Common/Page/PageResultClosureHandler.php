<?php

namespace Devster\CmsBundle\Crud\Common\Page;

use Devster\CmsBundle\Crud\PageInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class PageResultClosureHandler implements PageResultHandlerInterface
{
    /**
     * @param \Closure(UrlGeneratorInterface $urlGenerator, PageInterface $page, mixed $data): RedirectResponse $closure
     */
    public function __construct(protected readonly \Closure $closure)
    {
    }

    public function handle(UrlGeneratorInterface $urlGenerator, PageInterface $page, mixed $data): RedirectResponse
    {
        return ($this->closure)($urlGenerator, $page, $data);
    }
}