<?php

namespace Devster\CmsBundle\Crud\List\Cell\Renderer;

use Devster\CmsBundle\Crud\List\Cell\AbstractCell;
use Devster\CmsBundle\Crud\List\Cell\TextCell;
use Devster\CmsBundle\Util\ValueExtractor;

class TextCellRenderer extends AbstractCellRenderer
{
    protected function getViewData(AbstractCell $cell, mixed $data): array
    {
        if (!$cell instanceof TextCell) {
            throw new \RuntimeException('Nieobsługiwany typ komórki');
        }

        return [
            ...parent::getViewData($cell, $data),
            'value' => $this->getViewValue($cell, $data)
        ];
    }

    protected function getViewValue(TextCell $cell, mixed $data): mixed
    {
        return ValueExtractor::extractValue($data, $cell->getValue());
    }
}