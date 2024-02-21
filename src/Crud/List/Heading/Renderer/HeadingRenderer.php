<?php

namespace Devster\CmsBundle\Crud\List\Heading\Renderer;

use Devster\CmsBundle\Crud\List\AbstractField;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Environment;
use Twig\Markup;

class HeadingRenderer implements HeadingRendererInterface
{
    public function __construct(
        private readonly Environment  $twig,
        private readonly RequestStack $requestStack
    )
    {
    }

    public function render(AbstractField $field, PaginationInterface $pagination = null, ?string $rootAlias = null): Markup
    {
        if ($field->isSortable() && $pagination) {
            $sortField = $this->getQbFieldName($rootAlias, $field->getSortField());
            $direction = $pagination->getCustomParameter('sortedFields')[$sortField] ?? null;

            $newDirection = $direction == 'desc' ? 'asc' : 'desc';

            $options = [
                'href' => $this->getSortUrl($pagination, $sortField, $newDirection)
            ];

            $html = $this->twig->render(
                '@DevsterCms/crud/list/sortable_link.html.twig',
                [
                    'text' => $field->getHeading()->getText(),
                    'sorted' => !!$direction,
                    'direction' => $direction ?? 'asc',
                    'options' => $options
                ]
            );

            return new Markup($html, 'UTF-8');
        }

        return new Markup($field->getHeading()->getText(), 'UTF-8');
    }

    private function getSortUrl(PaginationInterface $pagination, string $param, string $direction): string
    {
        $request = $this->requestStack->getCurrentRequest();
        $queryParams = $request->query->all();

        $queryParams[$pagination->getPaginatorOption('sortFieldParameterName')] = $param;
        $queryParams[$pagination->getPaginatorOption('sortDirectionParameterName')] = $direction;

        return $request->getBaseUrl() . '?' . http_build_query($queryParams);
    }

    private function getQbFieldName(?string $rootAlias, string $field): string
    {
        if (!$rootAlias) {
            return $field;
        }

        if (!str_contains($field, '.')) {
            return $rootAlias . '.' . $field;
        }

        return $field;
    }
}