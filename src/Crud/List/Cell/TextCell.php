<?php

namespace Devster\CmsBundle\Crud\List\Cell;

use Devster\CmsBundle\Crud\List\Cell\Renderer\CommonCellRenderer;

/**
 * Dto wartości komórki tabeli
 */
class TextCell extends AbstractCell
{
    static public function create(string|\Closure $value): static
    {
        return new static($value);
    }

    public function __construct(
        protected string|\Closure $value
    )
    {
    }

    public function getRenderer(): string
    {
        return CommonCellRenderer::class;
    }

    public function value(string|\Closure $value): static
    {
        $this->value = $value;

        return $this;
    }

    public function getValue(): string|\Closure
    {
        return $this->value;
    }
}