<?php

namespace Devster\CmsBundle\Crud\List;

use Devster\CmsBundle\Crud\List\Cell\AbstractCell;
use Devster\CmsBundle\Crud\List\Cell\TextCell;
use Devster\CmsBundle\Crud\List\Cell\CellInterface;

class Field extends AbstractField
{
    static public function create(string $id, string $cellType = TextCell::class): static
    {
        return new static($id, $cellType);
    }

    protected CellInterface $value;

    public function __construct(string $id, string $cellType = TextCell::class)
    {
        parent::__construct($id);
        $this->value = new $cellType($this->id);
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
            $this->value->value($value);
        }

        return $this;
    }
}