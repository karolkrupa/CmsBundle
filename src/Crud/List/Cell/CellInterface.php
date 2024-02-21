<?php

namespace Devster\CmsBundle\Crud\List\Cell;

use Devster\CmsBundle\Crud\Common\Alignment;
use Devster\CmsBundle\Crud\Common\VerticalAlignment;

interface CellInterface
{
    public function getRenderer(): string;
    public function getViewVars(mixed $data): array;

    public function setAlignment(Alignment $alignment): static;
    public function setVerticalAlignment(VerticalAlignment $alignment): static;
    public function setBold(bool $bold = true): static;
    public function getAlignment(): Alignment;
    public function getVerticalAlignment(): VerticalAlignment;
    public function getBold(): bool;
}