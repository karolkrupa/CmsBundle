<?php

namespace Devster\CmsBundle\Crud\List\Cell;

/**
 * Dto wartości komórki tabeli
 */
class BoolCell extends TextCell
{
    protected ?string $template = '@DevsterCms/crud/list/cell/bool.html.twig';
}