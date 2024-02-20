<?php

namespace Devster\CmsBundle\Crud\List\Heading;


abstract class AbstractHeading implements HeadingInterface
{
    static public function create(string $text, ?string $field = null): static
    {
        return new static($text, $field);
    }

    protected bool $sortable = false;
    protected bool $center = false;
    protected bool $bold = false;
    protected string $align = 'left';

    public function __construct(
        protected string  $text,
        protected ?string $sortField = null
    )
    {
    }

    public function center(bool $center = true): static
    {
        $this->center = $center;

        return $this;
    }

    public function sortable(bool $sort): static
    {
        $this->sortable = $sort;

        return $this;
    }

    public function sortField(?string $sortField): static
    {
        $this->sortField = $sortField;

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

    public function getSortField(): ?string
    {
        return $this->sortField;
    }

    public function isSortable(): bool
    {
        return $this->sortable && $this->sortField;
    }
}