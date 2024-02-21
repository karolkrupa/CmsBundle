<?php

namespace Devster\CmsBundle\Crud\List\Cell;


/**
 * Dto wartości komórki tabeli
 */
class TextCell extends TemplateCell
{
    protected ?string $template = '@DevsterCms/crud/list/cell/text.html.twig';
}