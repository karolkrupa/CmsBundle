<?php

namespace Devster\CmsBundle\Crud\List\Action;

/**
 * Text button anchor
 *
 * @see AnchorAction
 */
class TextButtonAction extends AnchorAction
{
    const TEMPLATES = [
        self::COLOR_DEFAULT => '@DevsterCms/common/button/text/default.html.twig',
        self::COLOR_BLUE => '@DevsterCms/common/button/text/blue.html.twig',
        self::COLOR_RED => '@DevsterCms/common/button/text/red.html.twig',
        self::COLOR_GREEN => '@DevsterCms/common/button/text/green.html.twig'
    ];
}