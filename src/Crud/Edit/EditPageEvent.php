<?php

namespace Devster\CmsBundle\Crud\Edit;

use Symfony\Component\Form\FormInterface;

class EditPageEvent
{
    public function __construct(
        private readonly mixed $data,
        private readonly FormInterface $form
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
}