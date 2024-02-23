<?php

namespace Devster\CmsBundle\Crud\List\Action;


use Devster\CmsBundle\Crud\List\Action\Renderer\AnchorActionRenderer;

/**
 * Simple anchor action
 */
class AnchorAction extends Action
{
    /**
     * Templates for color variants
     */
    const TEMPLATES = [
        self::COLOR_DEFAULT => '@DevsterCms/common/anchor/default.html.twig',
        self::COLOR_BLUE => '@DevsterCms/common/anchor/blue.html.twig',
        self::COLOR_RED => '@DevsterCms/common/anchor/red.html.twig',
        self::COLOR_GREEN => '@DevsterCms/common/anchor/green.html.twig'
    ];

    protected ?string $route = null;
    protected array|\Closure $params = [];

    /**
     * Configure action route
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
     * Configure route params
     *
     * It allows configure params statically by array or dynamically by closure
     *
     * For example:
     * [ 'id' => 'registerId' ] - it should resolve id param by getter getRegisterId from cell data
     * function(User $user) { return [ 'id' => $user->getId() ] }
     *
     * @param array|\Closure(mixed $data):array $params
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

    public function getTemplate(): string
    {
        if ($this->template) {
            return $this->template;
        }

        if (!isset(static::TEMPLATES[$this->color])) {
            throw new \RuntimeException('Brak templatki dla koloru akcji: ' . $this->color);
        }

        return static::TEMPLATES[$this->color];
    }
}