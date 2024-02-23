<?php

namespace Devster\CmsBundle\Crud\List\Action;

/**
 * Button view anchor
 *
 * @see AnchorAction
 */
class ButtonAction extends AnchorAction
{
    const TEMPLATES = [
        self::COLOR_DEFAULT => '@DevsterCms/common/button/default.html.twig',
        self::COLOR_BLUE => '@DevsterCms/common/button/blue.html.twig',
        self::COLOR_RED => '@DevsterCms/common/button/red.html.twig',
        self::COLOR_GREEN => '@DevsterCms/common/button/green.html.twig'
    ];
}