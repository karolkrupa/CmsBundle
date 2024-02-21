<?php

namespace Devster\CmsBundle\Crud\List;

use Devster\CmsBundle\Crud\List\Action\Action;
use Devster\CmsBundle\Crud\List\Action\ActionInterface;
use Devster\CmsBundle\Crud\List\Cell\ActionCell;
use Devster\CmsBundle\Crud\List\Cell\ActionsCell;
use Devster\CmsBundle\Util\ValueExtractor;

class ActionField extends AbstractField
{
    protected ActionCell $cell;

    public function __construct(string $id, string $actionClass = Action::class)
    {
        parent::__construct($id);
        $this->cell = new ActionCell(new ($actionClass)(function (mixed $data) use ($id) {
            return ValueExtractor::extractValue($data, $id);
        }));
    }

    public static function create(string $property, ?string $actionClass = Action::class): static
    {
        return new static($property, $actionClass);
    }

    public function configureAction(\Closure $closure): static
    {
        $closure($this->cell->getAction());

        return $this;
    }

    public function getCell(): ActionCell
    {
        return $this->cell;
    }
}