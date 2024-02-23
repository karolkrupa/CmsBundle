<?php

namespace Devster\CmsBundle\Crud\List\Cell;

interface TitledCellInterface
{
    /**
     * Configure cell title
     *
     * @see TextCell::setValue
     *
     * @param string|\Closure|null $title
     * @return $this
     */
    public function setTitle(string|\Closure|null $title): static;

    public function getTitle(): string|\Closure|null;
}