<?php

namespace Devster\CmsBundle\Crud\List\Cell;

use Devster\CmsBundle\Crud\List\Action\ActionInterface;
use Devster\CmsBundle\Crud\List\Cell\Renderer\ActionCellRenderer;

class ActionCell extends AbstractCell
{
    protected function getDefaultTemplate(): ?string
    {
        return null;
    }

    public static function create(ActionInterface $action): static
    {
        return new static($action);
    }

    public function __construct(protected ActionInterface $action)
    {
    }


    /**
     * Konfiguracja akcji
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
}