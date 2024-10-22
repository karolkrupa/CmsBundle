<?php

namespace Devster\CmsBundle\Crud\List\Action\Renderer;

use Devster\CmsBundle\Crud\List\Action\ActionInterface;
use Devster\CmsBundle\Crud\List\Action\AnchorAction;
use Devster\CmsBundle\Util\ValueExtractor;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class AnchorActionRenderer extends ActionRenderer
{
    public static function getSubscribedServices(): array
    {
        return [
            ...parent::getSubscribedServices(),
            UrlGeneratorInterface::class
        ];
    }

    protected function getViewData(ActionInterface $action, mixed $data): array
    {
        if (!$action instanceof AnchorAction) {
            throw new \RuntimeException('Nieobsługiwany typ akcji');
        }

        $href = $this->getActionUrl($action, $data);

        return [
            ...parent::getViewData($action, $data),
            'href' => $href
        ];
    }

    protected function getActionUrl(ActionInterface $action, mixed $data = null): ?string
    {
        $url = null;
        if ($action->getRoute()) {
            $url = $this->getUrl($action->getRoute(), $action->getRouteParams(), $data);
        }

        return $url;
    }

    protected function getUrl(string $route, array|\Closure $routeParams = [], mixed $routeParamsContextData = null, array $strictRouteParams = []): ?string
    {
        return $this->urlGenerator()->generate(
            $route,
            [...$this->parseRouteParams($routeParams, $routeParamsContextData), ...$strictRouteParams]
        );
    }

    protected function parseRouteParams(array|\Closure $params, mixed $contextData): array
    {
        if (!$contextData) {
            if ($params && !is_array($params)) {
                throw new \LogicException('Akcje globalne obsługują jedynie tablicę parametrów');
            }

            return $params;
        }

        if (is_array($params)) {
            $params = $this->getDataParams($params, $contextData);
        } elseif ($params instanceof \Closure) {
            $params = $params($contextData);
        }

        return $params;
    }

    private function getDataParams(array $paramsConfig, mixed $data): array
    {
        $params = [];
        foreach ($paramsConfig as $paramName => $paramValue) {
            $params[$paramName] = $this->getParamValueFromData($paramValue, $data);
        }

        return $params;
    }

    private function getParamValueFromData(string $param, mixed $data)
    {
        return ValueExtractor::extractValue($data, $param);
    }

    private function urlGenerator(): UrlGeneratorInterface
    {
        return $this->container->get(UrlGeneratorInterface::class);
    }
}