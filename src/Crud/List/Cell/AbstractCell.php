<?php

namespace Devster\CmsBundle\Crud\List\Cell;

abstract class AbstractCell implements CellInterface
{
    protected bool $center = false;
    protected bool $bold = false;
    protected string $align = 'left';

    public function getViewVars(): array
    {
        return [];
    }

    public function center(bool $center = true): static
    {
        $this->center = $center;

        return $this;
    }

    public function bold(bool $bold = true): static
    {
        $this->bold = $bold;

        return $this;
    }

    public function align(string $align = 'left'): static
    {
        $this->align = $align;

        return $this;
    }

    public function getCenter(): bool
    {
        return $this->center;
    }

    public function getBold(): bool
    {
        return $this->bold;
    }

    public function getAlign(): string
    {
        return $this->align;
    }
}