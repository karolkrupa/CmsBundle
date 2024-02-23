<?php

namespace Devster\CmsBundle\Crud\Edit;

use Devster\CmsBundle\Crud\Common\View\Handler\AbstractPageViewHandler;
use Devster\CmsBundle\Crud\Common\View\PageViewInterface;
use Devster\CmsBundle\Crud\Common\View\PageViewPayloadInterface;
use Symfony\Component\HttpFoundation\Response;

class EditViewHandler extends AbstractPageViewHandler
{
    public function handle(PageViewInterface $view, PageViewPayloadInterface $payload): Response
    {
        if(!$view instanceof EditView) {
            throw new \RuntimeException('Niepoprawny typ widoku');
        }

        if(!$payload instanceof EditViewPayload) {
            throw new \RuntimeException('Niepoprawny payload');
        }

        $form = $view->getForm();

        $form->setData($payload->data);

        $form->handleRequest($payload->request);

        return new Response(
            $this->getRenderer($view->getRenderer())->render($view, $payload)
        );
    }
}