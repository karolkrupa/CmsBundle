<?php

namespace Devster\CmsBundle\Crud\Common\FormPage;

use Devster\CmsBundle\Crud\Common\PageViewInterface;
use Symfony\Component\Form\FormInterface;

class FormPageView implements PageViewInterface
{
    static public function create(): static
    {
        return new static();
    }

    protected ?string $title = null;
    protected ?string $successRoute = null;
    protected ?FormInterface $form = null;
    protected ?string $formTemplate = null;

    public function form(FormInterface $form): static
    {
        $this->form = $form;

        return $this;
    }

    public function title(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function successRoute(?string $route): static
    {
        $this->successRoute = $route;

        return $this;
    }

    public function formTemplate(?string $template): static
    {
        $this->formTemplate = $template;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getSuccessRoute(): ?string
    {
        return $this->successRoute;
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