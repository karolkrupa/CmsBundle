<?php

namespace Devster\CmsBundle\Crud\List\Cell\Renderer;

use Devster\CmsBundle\Crud\List\Cell\BoolCell;
use Devster\CmsBundle\Crud\List\Cell\DateCell;
use Devster\CmsBundle\Crud\List\Cell\TemplateCell;
use Devster\CmsBundle\Crud\List\Cell\TextCell;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
use Twig\Environment;
use Twig\Markup;

#[AutoconfigureTag(name: 'devster.cms.renderer.cell')]
class CommonCellRenderer
{
    public function __construct(
        private readonly Environment $twig
    )
    {
    }

    public function render(TemplateCell $cell, mixed $data): Markup
    {
        $html = $this->twig->render($this->getCellTemplate($cell), [
            'vars' => $cell->getViewVars($data),
            'value' => $this->getViewValue($cell, $data)
        ]);

        return new Markup($html, 'UTF-8');
    }

    private function getCellTemplate(TemplateCell $cell): string
    {
        $template = $cell->getTemplate();

        if (!$template) {
            throw new \RuntimeException('Brak szablonu komórki');
        }

        return $template;
    }

    private function getViewValue(TemplateCell $cell, mixed $data): mixed
    {
        $value = $cell->getValue();

        if ($value instanceof \Closure) {
            return $value($data);
        }

        if (is_array($data)) {
            if (!isset($data[$value])) {
                throw new \RuntimeException('Brak pola: ' . $value);
            }

            return $data[$value];
        }

        $getterName = ucfirst($value);
        $getters = [
            "get{$getterName}",
            "is{$getterName}"
        ];

        foreach ($getters as $getter) {
            if (method_exists($data, $getter)) {
                return $data->$getter();
            }
        }

        throw new \RuntimeException('Brak gettera dla pola: ' . $value);
    }
}