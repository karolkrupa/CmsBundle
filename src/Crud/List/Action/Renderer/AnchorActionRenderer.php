<?php

namespace Devster\CmsBundle\Crud\List\Action\Renderer;

use Devster\CmsBundle\Crud\List\Action\ActionInterface;
use Devster\CmsBundle\Crud\List\Action\AnchorAction;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Environment;
use Twig\Markup;

class AnchorActionRenderer implements ActionRenderInterface
{
    public function __construct(
        protected readonly Environment           $twig,
        protected readonly UrlGeneratorInterface $urlGenerator
    )
    {
    }

    public function renderPageView(ActionInterface $action): Markup
    {
        if(!$action instanceof AnchorAction) {
            throw new \RuntimeException('Nieobsługiwany typ akcji: '. get_class($action));
        }

        $template = $action->getTemplate('page')?? '@DevsterCms/common/button/button.html.twig';

        return $this->render($action, null, $template);
    }

    public function renderCellView(ActionInterface $action, mixed $data): Markup
    {
        if(!$action instanceof AnchorAction) {
            throw new \RuntimeException('Nieobsługiwany typ akcji: '. get_class($action));
        }

        $template = $action->getTemplate()?? '@DevsterCms/common/button/text/text_button.html.twig';

        return $this->render($action, $data, $template);
    }

    public function renderDropdownView(ActionInterface $action, mixed $data)
    {
        if(!$action instanceof AnchorAction) {
            throw new \RuntimeException('Nieobsługiwany typ akcji: '. get_class($action));
        }

        $template = $action->getTemplate('dropdown')?? '@DevsterCms/common/button/text/text_button.html.twig';

        return $this->render($action, $data, $template);
    }


    private function render(ActionInterface $action, mixed $data, string $template): Markup
    {
        $href = $this->getActionUrl($action, $data);

        $html = $this->twig->render($template, [
            'text' => $action->getName(),
            'href' => $href
        ]);

        return new Markup($html, 'UTF-8');
    }

    protected function getActionUrl(ActionInterface $action, mixed $data = null): ?string
    {
        $url = null;
        if($action->getRoute()) {
            $url = $this->urlGenerator->generate($action->getRoute(), $this->parseRouteParams($action, $data));
        }

        return $url;
    }

    protected function parseRouteParams(ActionInterface $action, mixed $data): array
    {
        $params = $action->getRouteParams();

        if(!$data) {
            if($params && !is_array($params)) {
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
        if (is_array($data)) {
            return $data[$param] ?? $param;
        }

        $getterProperty = ucfirst($param);
        $getters = [
            "get{$getterProperty}",
            "is{$getterProperty}"
        ];

        foreach ($getters as $getter) {
            if (method_exists($data, $getter)) {
                return $data->$getter();
            }
        }

        return $param;
    }
}