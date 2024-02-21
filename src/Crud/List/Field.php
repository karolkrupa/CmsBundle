<?php

namespace Devster\CmsBundle\Crud\List;

use Devster\CmsBundle\Crud\List\Cell\AbstractCell;
use Devster\CmsBundle\Crud\List\Cell\TextCell;
use Devster\CmsBundle\Crud\List\Cell\CellInterface;

class Field extends AbstractField
{
    static public function create(string $property, string $cellType = TextCell::class): static
    {
        return new static($property, $cellType);
    }

    protected CellInterface $value;

    public function __construct(string $property, string $cellType = TextCell::class)
    {
        parent::__construct($property);
        $this->value = new $cellType($this->property);
    }

    public function getCell(): AbstractCell
    {
        return $this->value;
    }

    public function cell(string|\Closure|CellInterface $value): static
    {
        if ($value instanceof TextCell) {
            $this->value = $value;
        } else {
            $this->value->setValue($value);
        }

        return $this;
    }
}