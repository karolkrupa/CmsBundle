<?php

namespace Devster\CmsBundle\Crud\Common\FormPage;

use Devster\CmsBundle\Crud\Common\View\PageViewInterface;
use Devster\CmsBundle\Crud\Common\View\TemplatePageView;
use Symfony\Component\Form\FormInterface;

class FormPageView extends TemplatePageView
{
    protected ?FormInterface $form = null;
    protected ?string $formTemplate = null;

    static public function create(): static
    {
        return new static();
    }

    public function getRenderer(): string
    {
        return FormPageViewRenderer::class;
    }

    public function setForm(FormInterface $form): static
    {
        $this->form = $form;

        return $this;
    }

    public function setFormTemplate(?string $template): static
    {
        $this->formTemplate = $template;

        return $this;
    }

    public function getForm(): ?FormInterface
    {
        return $this->form;
    }

    public function getFormTemplate(): ?string
    {
        return $this->formTemplate;
    }
}