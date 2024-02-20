<?php

namespace Devster\CmsBundle\Crud\List;

use Devster\CmsBundle\Crud\List\Action\Action;
use Devster\CmsBundle\Crud\List\Cell\ActionsCell;

class ActionsFiled extends AbstractField
{
    protected ActionsCell $cell;

    public function __construct(string $id)
    {
        parent::__construct($id);
        $this->cell = new ActionsCell();
    }

    public function getCell(): ActionsCell
    {
        return $this->cell;
    }

    public function add(Action $action): static
    {
        $this->cell->add($action);

        return $this;
    }

    public function asDropdown(bool $dropdown = true): static
    {
        $this->getCell()->asDropdown($dropdown);

        return $this;
    }
}