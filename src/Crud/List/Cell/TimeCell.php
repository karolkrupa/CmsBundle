<?php

namespace Devster\CmsBundle\Crud\List\Cell;

/**
 * Date cell type
 */
class TimeCell extends DateCell
{
    protected string $format = 'H:i';
}