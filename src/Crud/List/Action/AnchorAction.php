<?php

namespace Devster\CmsBundle\Crud\List\Action;


use Devster\CmsBundle\Crud\List\Action\Renderer\AnchorActionRenderer;

class AnchorAction extends Action
{
    protected ?string $route = null;
    protected array|\Closure $params = [];

    /**
     * Konfiguracja route akcji
     *
     * @param string $route
     * @return $this
     */
    public function setRoute(string $route): static
    {
        $this->route = $route;

        return $this;
    }

    /**
     * Konfiguracja parametrów dla route
     *
     * @param array|\Closure():array $params
     * @return $this
     */
    public function setRouteParams(array|\Closure $params): static
    {
        $this->params = $params;

        return $this;
    }

    public function getRoute(): ?string
    {
        return $this->route;
    }

    public function getRouteParams(): array|\Closure
    {
        return $this->params;
    }

    public function getRenderer(): string
    {
        return AnchorActionRenderer::class;
    }
}