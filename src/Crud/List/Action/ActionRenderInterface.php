<?php

namespace Devster\CmsBundle\Crud\List\Action;

interface ActionRenderInterface
{
    public function renderPageView(ActionInterface $action);

    public function renderCellView(ActionInterface $action, mixed $data);

    public function renderDropdownView(ActionInterface $action, mixed $data);
}