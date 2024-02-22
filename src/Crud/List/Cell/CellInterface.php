<?php

namespace Devster\CmsBundle\Crud\List\Cell;

use Devster\CmsBundle\Crud\Common\Alignment;
use Devster\CmsBundle\Crud\Common\TemplateableInterface;
use Devster\CmsBundle\Crud\Common\VerticalAlignment;

interface CellInterface extends TemplateableInterface
{
    public function getRenderer(): string;
    public function getViewVars(mixed $data): array;

    public function setClass(?string $class): static;
    public function setAlignment(Alignment $alignment): static;
    public function setVerticalAlignment(VerticalAlignment $alignment): static;
    public function setBold(bool $bold = true): static;
    public function getAlignment(): Alignment;
    public function getVerticalAlignment(): VerticalAlignment;
    public function getBold(): bool;
}