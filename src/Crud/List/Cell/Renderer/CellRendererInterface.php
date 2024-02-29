<?php

namespace Devster\CmsBundle\Crud\List\Cell\Renderer;

use Devster\CmsBundle\Crud\Common\View\PageViewContextInterface;
use Devster\CmsBundle\Crud\List\Cell\CellInterface;
use Twig\Markup;

interface CellRendererInterface
{
    public function render(CellInterface $cell, mixed $data, PageViewContextInterface $context): Markup;
}