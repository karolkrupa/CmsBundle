<?php

namespace Devster\CmsBundle\Crud\Common\Page;

use Devster\CmsBundle\Crud\PageInterface;
use Devster\CmsBundle\Util\ValueExtractor;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class PageResultRouteHandler implements PageResultHandlerInterface
{
    public function __construct(
        protected string $route,
        protected array  $routeParams
    )
    {
    }

    public function handle(UrlGeneratorInterface $urlGenerator, PageInterface $page, mixed $data): RedirectResponse
    {
        $routeParams = $this->routeParams;

        foreach ($routeParams as &$param) {
            $extractedValue = ValueExtractor::extractValue($data, $param, [$data], false);

            if($extractedValue !== null) {
                $param = $extractedValue;
            }
        }

        return new RedirectResponse($urlGenerator->generate($this->route, $routeParams));
    }
}