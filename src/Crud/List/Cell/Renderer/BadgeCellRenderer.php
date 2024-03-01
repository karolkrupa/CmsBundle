<?php

namespace Devster\CmsBundle\Crud\List\Cell\Renderer;

use Devster\CmsBundle\Crud\Common\View\PageViewContextInterface;
use Devster\CmsBundle\Crud\List\Cell\CellInterface;

class BadgeCellRenderer extends TextCellRenderer
{
    protected function getTemplate(CellInterface $cell, mixed $data, PageViewContextInterface $context): string
    {
        return $cell->getTemplate($data);
    }
}