<?php

namespace Devster\CmsBundle\Crud\List\Cell;

interface TitledCellInterface
{
    public function setTitle(string|\Closure|null $title): static;
    public function getTitle(): string|\Closure|null;
}