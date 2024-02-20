<?php

namespace Devster\CmsBundle\Crud\List;

use Devster\CmsBundle\Crud\Common\PageViewInterface;
use Devster\CmsBundle\Crud\List\Action\ActionInterface;
use Devster\CmsBundle\Crud\List\FilterForm\FilterForm;

/**
 * Dto widoku listy
 */
class ListView implements PageViewInterface
{
    public ?string $title = null;
    public array $fields = [];
    public array $actions = [];
    public ?FilterForm $filterForm = null;

    public function title(?string $title = null): static
    {
        $this->title = $title;

        return $this;
    }

    public function addField($listField): self
    {
        $this->fields[] = $listField;

        return $this;
    }

    /**
     * @return Field[]
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    public function setFilterForm(FilterForm $form): static
    {
        $this->filterForm = $form;

        return $this;
    }

    public function getFilterForm(): ?FilterForm
    {
        return $this->filterForm;
    }

    public function addAction(ActionInterface $action): static
    {
        $this->actions[] = $action;

        return $this;
    }

    /**
     * @return ActionInterface[]
     */
    public function getActions(): array
    {
        return $this->actions;
    }
}