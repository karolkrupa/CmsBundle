<?php

namespace Devster\CmsBundle\Crud\Edit;

use Symfony\Component\Form\FormInterface;

class EditPageEvent
{
    public function __construct(
        private readonly mixed $data,
        private readonly FormInterface $form,
        private readonly EditPage $page
    )
    {
    }

    public function getData(): mixed
    {
        return $this->data;
    }

    public function getForm(): FormInterface
    {
        return $this->form;
    }

    public function getPage(): EditPage
    {
        return $this->page;
    }
}