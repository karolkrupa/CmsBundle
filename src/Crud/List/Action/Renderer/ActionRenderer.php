<?php

namespace Devster\CmsBundle\Crud\List\Action\Renderer;

use Devster\CmsBundle\Crud\List\Action\ActionInterface;
use Symfony\Contracts\Service\Attribute\SubscribedService;
use Symfony\Contracts\Service\ServiceSubscriberInterface;
use Symfony\Contracts\Service\ServiceSubscriberTrait;
use Twig\Environment;
use Twig\Markup;

class ActionRenderer implements ActionRenderInterface, ServiceSubscriberInterface
{
    use ServiceSubscriberTrait;

    public function render(ActionInterface $action, mixed $data): Markup
    {
        $template = $action->getTemplate() ?? '@DevsterCms/crud/list/action/action.html.twig';

        $html = $this->twig()->render($template, $this->getViewData($action, $data));

        return new Markup($html, 'UTF-8');
    }

    protected function getViewData(ActionInterface $action, mixed $data): array
    {
        return [
            'action' => $action,
            'text' => $action->getText() instanceof \Closure ? $action->getText()($data) : $action->getText()
        ];
    }

    #[SubscribedService]
    protected function twig(): Environment
    {
        return $this->container->get(__METHOD__);
    }
}