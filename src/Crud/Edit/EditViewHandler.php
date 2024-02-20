<?php

namespace Devster\CmsBundle\Crud\Edit;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class EditViewHandler
{
    public function __construct(
        private readonly EditViewRenderer $editViewRenderer
    )
    {
    }

    public function handle(
        EditView $editView,
        Request  $request,
        mixed    $data
    ): Response
    {
        $form = $editView->getForm();

        $form->setData($data);

        $form->handleRequest($request);

        return new Response(
            $this->editViewRenderer->render($editView, $data)
        );
    }
}