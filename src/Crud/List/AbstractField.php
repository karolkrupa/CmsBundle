<?php

namespace Devster\CmsBundle\Crud\List;

use Devster\CmsBundle\Crud\List\Cell\CellInterface;
use Devster\CmsBundle\Crud\List\Heading\Heading;

abstract class AbstractField
{
    static public function create(string $id): static
    {
        return new static($id);
    }

    protected Heading $heading;
    protected bool $fit = false;

    public function __construct(
        protected readonly string $id
    )
    {
        $this->heading = new Heading($this->id, $this->id);
    }

    public function getHeading(): Heading
    {
        return $this->heading;
    }

    abstract public function getCell(): CellInterface;

    public function configureCell(\Closure $closure): static
    {
        $closure($this->getCell());

        return $this;
    }

    public function heading(string|Heading $heading): static
    {
        if (is_string($heading)) {
            $this->heading->text($heading);
        } else {
            $this->heading = $heading;
        }

        return $this;
    }

    public function fit(bool $fit = true): static
    {
        $this->fit = $fit;

        return $this;
    }

    public function isFit(): bool
    {
        return $this->fit;
    }

    public function sortable(bool $sort = true): static
    {
        $this->heading->sortable($sort);

        return $this;
    }

    public function sortField(?string $sortField): static
    {
        $this->heading->sortField($sortField);

        return $this;
    }
}