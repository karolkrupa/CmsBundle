<?php

namespace Devster\CmsBundle\Crud\List\Cell\Renderer;

use Devster\CmsBundle\Crud\List\Cell\BoolCell;
use Devster\CmsBundle\Crud\List\Cell\DateCell;
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

    public function render(TextCell $cell, mixed $data): Markup
    {
        $html = $this->twig->render($this->getCellTemplate($cell), [
            'vars' => $cell->getViewVars(),
            'value' => $this->getViewValue($cell, $data)
        ]);

        return new Markup($html, 'UTF-8');
    }

    private function getCellTemplate(TextCell $cell): string
    {
        $cellClass = get_class($cell);

        $map = [
            TextCell::class => '@DevsterCms/crud/list/cell/text.html.twig',
            BoolCell::class => '@DevsterCms/crud/list/cell/bool.html.twig',
            DateCell::class => '@DevsterCms/crud/list/cell/date.html.twig',
        ];

        if (!isset($map[$cellClass])) {
            throw new \RuntimeException('Nieznany typ komórki');
        }

        return $map[$cellClass];
    }

    private function getViewValue(TextCell $value, mixed $data): mixed
    {
        $value = $value->getValue();

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