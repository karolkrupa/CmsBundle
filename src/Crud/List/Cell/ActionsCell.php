<?php

namespace Devster\CmsBundle\Crud\List\Cell;

use Devster\CmsBundle\Crud\List\Action\Action;
use Devster\CmsBundle\Crud\List\Cell\Renderer\ActionsCellRenderer;

/**
 * Dto wartości komórki tabeli
 */
class ActionsCell extends AbstractCell
{
    protected array $actions = [];
    protected bool $dropdown = false;

    /**
     * Dodanie akcji do listy
     *
     * @param Action $action
     * @return $this
     */
    public function add(Action $action): static
    {
        $this->actions[] = $action;

        return $this;
    }

    /**
     * Konfiguracja wyświetlania akcji jako dropdown
     *
     * @param bool $dropdown
     * @return $this
     */
    public function asDropdown(bool $dropdown = true): static
    {
        $this->dropdown = $dropdown;

        return $this;
    }

    public function isDropdown(): bool
    {
        return $this->dropdown;
    }

    /**
     * @return Action[]
     */
    public function getActions(): array
    {
        return $this->actions;
    }

    public function getRenderer(): string
    {
        return ActionsCellRenderer::class;
    }
}