<?php

namespace Devster\CmsBundle\Crud\List\Cell\Renderer;

use Devster\CmsBundle\Crud\List\Cell\AbstractCell;
use Devster\CmsBundle\Crud\List\Cell\TextCell;

class TextCellRenderer extends AbstractCellRenderer
{
    protected function getViewData(AbstractCell $cell, mixed $data): array
    {
        if(!$cell instanceof TextCell) {
            throw new \RuntimeException('Nieobsługiwany typ komórki');
        }

        return [
            ...parent::getViewData($cell, $data),
            'value' => $this->getViewValue($cell, $data)
        ];
    }

    protected function getViewValue(TextCell $cell, mixed $data): mixed
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