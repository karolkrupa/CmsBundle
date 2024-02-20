<?php

namespace Devster\CmsBundle\Crud\Common;

interface PageRendererInterface
{
    public function render(PageViewInterface $view, mixed $data): string;
}