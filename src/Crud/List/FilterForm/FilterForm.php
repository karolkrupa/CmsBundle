<?php

namespace Devster\CmsBundle\Crud\List\FilterForm;

use Devster\CmsBundle\Crud\Common\TemplateableInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;

class FilterForm implements TemplateableInterface
{
    protected ?FormInterface $form = null;
    protected array $configurations = [];
    protected array $searchFields = [];
    private ?FormInterface $baseForm = null;
    protected ?string $template = '@DevsterCms/crud/list/filter/form.html.twig';

    static public function create(): static
    {
        return new static();
    }

    /**
     * Konfiguracja pól dla wyszukiwarki
     *
     * @param array $searchFields
     * @return $this
     */
    public function setSearchFields(array $searchFields): static
    {
        $this->searchFields = $searchFields;

        return $this;
    }

    /**
     * Konfiguracja formularza filtrów
     *
     * @param FormInterface $form
     * @return $this
     */
    public function setForm(FormInterface $form): static
    {
        $this->form = $form;

        return $this;
    }

    /**
     * Konfiguracja templatki dla formularza
     *
     * @param string|null $template
     * @return $this
     */
    public function setTemplate(?string $template): static
    {
        $this->template = $template;

        return $this;
    }

    /**
     * Konfiguracja obsługi filtrowania dla danego pola
     *
     * @param string $field
     * @param \Closure(FormField $field):void $closure
     * @return $this
     */
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

    public function getTemplate(): string
    {
        return $this->template;
    }

    public function getBaseForm(FormFactoryInterface $formFactory): FormInterface
    {
        return $formFactory->createBuilder()
            ->getForm();
    }
}