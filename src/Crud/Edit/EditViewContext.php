<?php

namespace Devster\CmsBundle\Crud\Edit;

use Devster\CmsBundle\Crud\Common\View\PageViewContextInterface;
use Symfony\Component\Form\FormInterface;

class EditViewContext implements PageViewContextInterface
{
    public function __construct(
        private readonly FormInterface $form
    )
    {
    }

    public function getForm(): FormInterface
    {
        return $this->form;
    }
}