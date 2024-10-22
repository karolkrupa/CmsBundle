<?php

namespace Devster\CmsBundle\Crud\List\Action;

use Devster\CmsBundle\Crud\List\Action\Renderer\SortableButtonsActionRenderer;

/**
 * Sortable buttons
 */
class SortableButtonsAction extends AnchorAction
{
    protected ?string $template = '@DevsterCms/crud/list/action/sortable_buttons_action.html.twig';

    protected string $sortDirectionParam = 'sort';
    protected string $sortPreviousValue = 'previous';
    protected string $sortNextValue = 'next';

    public function getRenderer(): string
    {
        return SortableButtonsActionRenderer::class;
    }

    public function getSortDirectionParam(): string
    {
        return $this->sortDirectionParam;
    }

    public function setSortDirectionParam(string $sortDirectionParam): static
    {
        $this->sortDirectionParam = $sortDirectionParam;

        return $this;
    }

    public function getSortPreviousValue(): string
    {
        return $this->sortPreviousValue;
    }

    public function setSortPreviousValue(string $sortPreviousValue): static
    {
        $this->sortPreviousValue = $sortPreviousValue;

        return $this;
    }

    public function getSortNextValue(): string
    {
        return $this->sortNextValue;
    }

    public function setSortNextValue(string $sortNextValue): static
    {
        $this->sortNextValue = $sortNextValue;

        return $this;
    }
}