<?php

namespace Devster\CmsBundle\Crud\List\Action;


class AnchorAction extends Action
{
    protected ?string $route = null;
    protected array|\Closure $params = [];


    public function getRenderer(): string
    {
        return AnchorActionRenderer::class;
    }

    public function route(string $route): static
    {
        $this->route = $route;

        return $this;
    }

    public function params(array|\Closure $params): static
    {
        $this->params = $params;

        return $this;
    }

    public function getRoute(): ?string
    {
        return $this->route;
    }

    public function getParams(): array|\Closure
    {
        return $this->params;
    }
}