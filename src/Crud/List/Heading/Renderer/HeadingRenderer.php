<?php

namespace Devster\CmsBundle\Crud\List\Heading\Renderer;

use Devster\CmsBundle\Crud\List\Heading\Heading;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Environment;
use Twig\Markup;

#[AutoconfigureTag(name: 'devster.cms.renderer.heading')]
class HeadingRenderer
{
    public function __construct(
        private readonly Environment  $twig,
        private readonly RequestStack $requestStack
    )
    {
    }

    public function render(Heading $heading, PaginationInterface $pagination = null): Markup
    {
        if ($heading->isSortable() && $pagination) {
            $sortField = $heading->getSortField();
            $direction = $pagination->getCustomParameter('sortedFields')[$sortField] ?? null;

            $newDirection = $direction == 'desc'? 'asc' : 'desc';

            $options = [
                'href' => $this->getSortUrl($pagination, $sortField, $newDirection)
            ];

            $html = $this->twig->render(
                '@DevsterCms/crud/list/sortable_link.html.twig',
                [
                    'text' => $heading->getText(),
                    'sorted' => !!$direction,
                    'direction' => $direction ?? 'asc',
                    'options' => $options
                ]
            );

            return new Markup($html, 'UTF-8');
        }

        return new Markup($heading->getText(), 'UTF-8');
    }

    private function getSortUrl(PaginationInterface $pagination, string $param, string $direction): string
    {
        $request = $this->requestStack->getCurrentRequest();
        $queryParams = $request->query->all();

        $queryParams[$pagination->getPaginatorOption('sortFieldParameterName')] = $param;
        $queryParams[$pagination->getPaginatorOption('sortDirectionParameterName')] = $direction;

        return $request->getBaseUrl() . '?' . http_build_query($queryParams);
    }
}