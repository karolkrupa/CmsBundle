<?php

namespace Devster\CmsBundle\Crud\List\FilterForm;

use Symfony\Component\Form\FormInterface;

class FilterForm
{
    static public function create(?string $alias = null): static
    {
        return new static($alias);
    }


    protected ?FormInterface $form = null;
    protected array $configurations = [];
    protected array $searchFields = [];

    public function __construct(
        protected ?string $alias = null
    )
    {
    }

    /**
     * Root z QB alias dla filtrów
     */
    public function alias(string $alias): static
    {
        $this->alias = $alias;

        return $this;
    }

    public function searchFields(array $searchFields): static
    {
        $this->searchFields = $searchFields;

        return $this;
    }

    public function form(FormInterface $form): static
    {
        $this->form = $form;

        return $this;
    }

    public function configureField(string $field, \Closure $closure): static
    {
        if (!isset($this->configurations[$field])) {
            $this->configurations[$field] = new FormField();
        }

        $closure($this->configurations[$field]);

        return $this;
    }

    public function getForm(): ?FormInterface
    {
        return $this->form;
    }

    public function getConfigurations(): array
    {
        return $this->configurations;
    }

    public function getAlias(): ?string
    {
        return $this->alias;
    }

    public function getSearchFields(): array
    {
        return $this->searchFields;
    }
}