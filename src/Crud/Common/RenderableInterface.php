<?php

namespace Devster\CmsBundle\Crud\Common;

/**
 * Interface for views that can be rendered by renderer
 */
interface RenderableInterface
{
    public function getRenderer(): string;
}