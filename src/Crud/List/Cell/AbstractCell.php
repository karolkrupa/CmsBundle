<?php

namespace Devster\CmsBundle\Crud\List\Cell;

abstract class AbstractCell implements CellInterface
{
    protected bool $center = false;
    protected bool $bold = false;
    protected string $align = 'left';
    protected null|string|\Closure $title = null;

    public function getViewVars(mixed $data): array
    {
        return [
            'title' => $this->title instanceof \Closure ? ($this->title)($data) : $this->title
        ];
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

    public function getTitle(): string|\Closure|null
    {
        return $this->title;
    }

    public function title(string|\Closure|null $title): static
    {
        $this->title = $title;

        return $this;
    }
}