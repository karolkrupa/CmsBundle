<?php

namespace Devster\CmsBundle\Crud\List;

use Devster\CmsBundle\Crud\List\Action\Action;
use Devster\CmsBundle\Crud\List\Action\ActionInterface;
use Devster\CmsBundle\Crud\List\Cell\ActionCell;
use Devster\CmsBundle\Crud\List\Cell\ActionsCell;

class ActionField extends AbstractField
{
    protected ActionCell $cell;

    public function __construct(string $id, protected ActionInterface $action)
    {
        parent::__construct($id);
        $this->cell = new ActionCell($action);
    }

    public static function create(string $id, ActionInterface $action = null): static
    {
        return new static($id, $action);
    }

    public function getCell(): ActionCell
    {
        return $this->cell;
    }
}