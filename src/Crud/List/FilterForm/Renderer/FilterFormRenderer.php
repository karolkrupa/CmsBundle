<?php

namespace Devster\CmsBundle\Crud\List\FilterForm\Renderer;

use Devster\CmsBundle\Crud\List\FilterForm\FilterForm;
use Symfony\Component\Form\FormFactoryInterface;
use Twig\Environment;
use Twig\Markup;

class FilterFormRenderer
{
    public function __construct(
        private readonly Environment          $twig,
        private readonly FormFactoryInterface $formFactory
    )
    {
    }

    public function render(FilterForm $filterForm): array
    {
        $formView = $filterForm->getForm($this->formFactory)->createView();

        $html = $this->twig->render(
            $filterForm->getTemplate(),
            [
                'form' => $formView
            ]
        );

        $controlsHtml = $this->twig->render(
            '@DevsterCms/crud/list/filter/form_controls.html.twig',
            [
                'form' => $formView
            ]
        );

        return [
            'form' => new Markup($html, 'UTF-8'),
            'controls' => new Markup($controlsHtml, 'UTF-8')
        ];
    }

}