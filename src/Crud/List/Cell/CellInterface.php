<?php

namespace Devster\CmsBundle\Crud\List\Cell;

interface CellInterface
{
    public function getRenderer(): string;

    public function getViewVars(): array;

    public function center(bool $center = true): static;
    public function bold(bool $bold = true): static;
    public function align(string $align = 'left'): static;


    public function getCenter(): bool;
    public function getBold(): bool;
    public function getAlign(): string;
}