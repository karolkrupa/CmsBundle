<?php

namespace Devster\CmsBundle\Crud\Common\FormPage;

use Devster\CmsBundle\Crud\Common\View\Renderer\TemplatePageViewRenderer;
use Devster\CmsBundle\Crud\Common\View\PageViewContextInterface;
use Devster\CmsBundle\Crud\Common\View\PageViewInterface;
use Devster\CmsBundle\Crud\Common\View\PageViewPayloadInterface;

class FormPageViewRenderer extends TemplatePageViewRenderer
{
    public function render(PageViewInterface $view, PageViewPayloadInterface $payload, PageViewContextInterface $context): string
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