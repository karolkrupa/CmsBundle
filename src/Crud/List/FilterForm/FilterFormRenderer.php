<?php

namespace Devster\CmsBundle\Crud\List\FilterForm;

use Twig\Environment;
use Twig\Markup;

class FilterFormRenderer
{
    public function __construct(
        private readonly Environment $twig
    )
    {
    }

    public function render(FilterForm $filterForm): array
    {
        $formView = $filterForm->getForm()->createView();

        $html = $this->twig->render(
            '@DevsterCms/crud/list/filter/form.html.twig',
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