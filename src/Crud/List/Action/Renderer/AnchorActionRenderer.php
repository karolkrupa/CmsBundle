<?php

namespace Devster\CmsBundle\Crud\List\Action\Renderer;

use Devster\CmsBundle\Crud\List\Action\ActionInterface;
use Devster\CmsBundle\Util\ValueExtractor;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Markup;

class AnchorActionRenderer extends ActionRenderer
{
    public static function getSubscribedServices(): array
    {
        return [
            ...parent::getSubscribedServices(),
            UrlGeneratorInterface::class
        ];
    }

    public function render(ActionInterface $action, mixed $data): Markup
    {
        $href = $this->getActionUrl($action, $data);

        $template = $action->getTemplate() ?? '@DevsterCms/common/anchor/default.html.twig';

        $html = $this->twig()->render($template, [
            ...$this->getViewData($action, $data),
            'href' => $href
        ]);

        return new Markup($html, 'UTF-8');
    }

    protected function getActionUrl(ActionInterface $action, mixed $data = null): ?string
    {
        $url = null;
        if ($action->getRoute()) {
            $url = $this->urlGenerator()->generate($action->getRoute(), $this->parseRouteParams($action, $data));
        }

        return $url;
    }

    protected function parseRouteParams(ActionInterface $action, mixed $data): array
    {
        $params = $action->getRouteParams();

        if (!$data) {
            if ($params && !is_array($params)) {
                throw new \LogicException('Akcje globalne obsługują jedynie tablicę parametrów');
            }

            return $params;
        }

        if (is_array($params)) {
            $params = $this->getDataParams($params, $data);
        } elseif ($params instanceof \Closure) {
            $params = $params($data);
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