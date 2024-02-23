<?php

namespace Devster\CmsBundle\Crud\List\Cell;

use Devster\CmsBundle\Crud\List\Action\ActionInterface;
use Devster\CmsBundle\Crud\List\Cell\Renderer\ActionCellRenderer;

/**
 * Cell with one action
 */
class ActionCell extends AbstractCell
{
    public function __construct(protected ActionInterface $action)
    {
    }

    public static function create(ActionInterface $action): static
    {
        return new static($action);
    }

    /**
     * Set embedded action
     *
     * @param ActionInterface $action
     * @return $this
     */
    public function setAction(ActionInterface $action): static
    {
        $this->action = $action;

        return $this;
    }

    public function getAction(): ?ActionInterface
    {
        return $this->action;
    }

    public function getRenderer(): string
    {
        return ActionCellRenderer::class;
    }

    protected function getDefaultTemplate(): ?string
    {
        return null;
    }
}