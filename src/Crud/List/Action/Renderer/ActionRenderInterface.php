<?php

namespace Devster\CmsBundle\Crud\List\Action\Renderer;

use Devster\CmsBundle\Crud\List\Action\ActionInterface;
use Twig\Markup;

interface ActionRenderInterface
{
    public function render(ActionInterface $action, mixed $data): Markup;
}