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

    /**
     * Konfiguracja szablonu widoku
     *
     * @param string|null $template
     * @return $this
     */
    public function setTemplate(?string $template): static
    {
        $this->template = $template;

        return $this;
    }

    /**
     * Konfiguracja danych przekazywanych do widoku komórki
     *
     * @param string|\Closure(mixed $cellData):mixed $value
     * @return $this
     */
    public function setValue(string|\Closure $value): static
    {
        $this->value = $value;

        return $this;
    }

    public function getValue(): null|string|\Closure
    {
        return $this->value;
    }

    public function getTemplate(): ?string
    {
        return $this->template;
    }

    public function getRenderer(): string
    {
        return CommonCellRenderer::class;
    }
}