<?php

namespace Devster\CmsBundle\Crud\Common\FormPage;

use Devster\CmsBundle\Crud\Common\PageRendererInterface;
use Devster\CmsBundle\Crud\Common\PageViewInterface;
use Twig\Environment;

class FormPageRenderer implements PageRendererInterface
{
    public function __construct(
        protected readonly Environment $twig
    )
    {
    }

    public function render(PageViewInterface $view, mixed $data = null): string
    {
        if (!$view instanceof FormPageView) {
            throw new \LogicException('Oczekiwany typ: ' . FormPageView::class);
        }

        return $this->twig->render(
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