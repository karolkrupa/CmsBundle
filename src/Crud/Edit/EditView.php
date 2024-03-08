<?php

namespace Devster\CmsBundle\Crud\Edit;

use Devster\CmsBundle\Crud\Common\FormPage\FormPageView;

class EditView extends FormPageView
{
    public function getHandler(): string
    {
        return EditViewHandler::class;
    }

}