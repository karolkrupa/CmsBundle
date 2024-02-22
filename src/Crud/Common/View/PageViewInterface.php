<?php

namespace Devster\CmsBundle\Crud\Common\View;

use Devster\CmsBundle\Crud\Common\RenderableInterface;
use Devster\CmsBundle\Crud\Common\TemplateableInterface;

interface PageViewInterface extends TemplateableInterface, RenderableInterface
{
    public function getHandler(): string;

    public function setTitle(string $title): static;


    public function getTitle(): string;
}