<?php

namespace Devster\CmsBundle\Crud\List\Cell;

interface CellInterface
{
    public function getRenderer(): string;
    public function getViewVars(mixed $data): array;

    public function setCenter(bool $center = true): static;
    public function setBold(bool $bold = true): static;
    public function getCenter(): bool;
    public function getBold(): bool;
}