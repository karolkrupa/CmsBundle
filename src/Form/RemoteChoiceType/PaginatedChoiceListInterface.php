<?php

namespace Devster\CmsBundle\Form\RemoteChoiceType;

interface PaginatedChoiceListInterface
{
    /**
     * @return array
     */
    public function getChoices(): array;

    public function getPageNumber(): int;

    public function getPagesAmount(): int;
}