<?php

namespace Devster\CmsBundle\Form\RemoteChoiceType;

class PaginatedChoiceList implements PaginatedChoiceListInterface
{
    public function __construct(
        private readonly array $choices,
        private readonly int $pageNumber,
        private readonly int $pagesAmount
    )
    {
    }

    public function getChoices(): array
    {
        return $this->choices;
    }

    public function getPageNumber(): int
    {
        return $this->pageNumber;
    }

    public function getPagesAmount(): int
    {
        return $this->pagesAmount;
    }
}