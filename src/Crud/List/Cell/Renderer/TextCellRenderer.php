<?php

namespace Devster\CmsBundle\Crud\List\Cell\Renderer;

use Devster\CmsBundle\Crud\Common\View\PageViewContextInterface;
use Devster\CmsBundle\Crud\List\Cell\CellInterface;
use Devster\CmsBundle\Crud\List\Cell\TextCell;
use Devster\CmsBundle\Util\ValueExtractor;

class TextCellRenderer extends AbstractCellRenderer
{
    protected function getViewData(CellInterface $cell, mixed $data, PageViewContextInterface $context): array
    {
        if (!$cell instanceof TextCell) {
            throw new \RuntimeException('Nieobsługiwany typ komórki');
        }

        return [
            ...parent::getViewData($cell, $data, $context),
            'value' => $this->getViewValue($cell, $data, $context)
        ];
    }

    protected function getViewValue(TextCell $cell, mixed $data, PageViewContextInterface $context): mixed
    {
        return ValueExtractor::extractValue($data, $cell->getValue(), [$context]);
    }
}