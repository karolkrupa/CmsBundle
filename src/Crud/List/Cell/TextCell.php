<?php

namespace Devster\CmsBundle\Crud\List\Cell;

use Devster\CmsBundle\Crud\List\Cell\Renderer\CommonCellRenderer;

/**
 * Dto wartości komórki tabeli
 */
class TextCell extends TemplateCell
{
    protected ?string $template = '@DevsterCms/crud/list/cell/text.html.twig';
}