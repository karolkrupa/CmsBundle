<?php

namespace Devster\CmsBundle\Crud\Common\FormPage;

use Devster\CmsBundle\Crud\Common\TemplatePage\Renderer\TemplatePageViewRenderer;
use Devster\CmsBundle\Crud\Common\View\PageViewContextInterface;
use Devster\CmsBundle\Crud\Common\View\PageViewInterface;
use Devster\CmsBundle\Crud\PagePayloadInterface;

class FormPageViewRenderer extends TemplatePageViewRenderer
{
    public function render(PageViewInterface $view, PagePayloadInterface $payload, PageViewContextInterface $context): string
    {
        if (!$view instanceof FormPageView) {
            throw new \LogicException('Oczekiwany typ: ' . FormPageView::class);
        }

        return $this->twig()->render(
            '@DevsterCms/crud/common/form/view.html.twig',
            [
                'form' => $view->getForm()->createView(),
                'formTemplate' => $view->getFormTemplate(),
                'title' => $view->getTitle(),
                'data' => $view->getForm()->getData()
            ]
        );
    }
}