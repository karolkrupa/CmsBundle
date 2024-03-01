<?php

namespace Devster\CmsBundle\Crud\List\Cell;

/**
 * Date cell type
 */
class DateTimeCell extends DateCell
{
    protected string $format = 'Y-m-d H:i';
}