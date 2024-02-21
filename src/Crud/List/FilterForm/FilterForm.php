<?php

namespace Devster\CmsBundle\Crud\List\FilterForm;

use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;

class FilterForm
{
    static public function create(): static
    {
        return new static();
    }

    protected ?FormInterface $form = null;
    protected array $configurations = [];
    protected array $searchFields = [];

    private ?FormInterface $baseForm = null;

    public function __construct()
    {
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

    public function getForm(FormFactoryInterface $formFactory): ?FormInterface
    {
        if (!$this->form && !$this->baseForm) {
            $this->baseForm = $this->getBaseForm($formFactory);
        }

        return $this->form ?: $this->baseForm;
    }

    public function getConfigurations(): array
    {
        return $this->configurations;
    }

    public function getSearchFields(): array
    {
        return $this->searchFields;
    }

    public function getBaseForm(FormFactoryInterface $formFactory): FormInterface
    {
        return $formFactory->createBuilder()
            ->getForm();
    }
}