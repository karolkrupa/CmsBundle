<?php

namespace Devster\CmsBundle\Crud\List\Cell;

use Devster\CmsBundle\Crud\List\Cell\Renderer\CommonCellRenderer;

class TemplateCell extends AbstractCell
{
    static public function create(string|\Closure $value): static
    {
        return new static($value);
    }

    protected ?string $template = null;

    public function __construct(protected string|\Closure $value)
    {
    }

    public function getRenderer(): string
    {
        return CommonCellRenderer::class;
    }

    public function template(?string $template): static
    {
        $this->template = $template;

        return $this;
    }

    public function getTemplate(): ?string
    {
        return $this->template;
    }

    public function value(string|\Closure $value): static
    {
        $this->value = $value;

        return $this;
    }

    public function getValue(): null|string|\Closure
    {
        return $this->value;
    }
}