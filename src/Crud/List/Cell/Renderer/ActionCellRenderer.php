<?php

namespace Devster\CmsBundle\Crud\List\Cell\Renderer;

use Devster\CmsBundle\Crud\Common\View\PageViewContextInterface;
use Devster\CmsBundle\Crud\List\Action\ActionInterface;
use Devster\CmsBundle\Crud\List\Action\Renderer\ActionRenderInterface;
use Devster\CmsBundle\Crud\List\Cell\ActionCell;
use Devster\CmsBundle\Crud\List\Cell\CellInterface;
use Psr\Container\ContainerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Contracts\Service\Attribute\SubscribedService;
use Twig\Markup;

class ActionCellRenderer extends AbstractCellRenderer
{
    public static function getSubscribedServices(): array
    {
        return [
            ...parent::getSubscribedServices(),
            new SubscribedService('action_renderers', ContainerInterface::class, attributes: new Autowire(service: 'devster.cms.renderer.action.locator'))
        ];
    }

    public function render(CellInterface $cell, mixed $data, PageViewContextInterface $context): Markup
    {
        if (!$cell instanceof ActionCell) {
            throw new \RuntimeException('Nieznany typ komórki');
        }

        $action = $cell->getAction();

        $renderer = $this->getActionRenderer($action);

        if ($cell->getTemplate()) {
            $html = $this->twig()->render(
                $cell->getTemplate(),
                [
                    ...$this->getViewData($cell, $data, $context),
                    'actionHtml' => $renderer->render($action, $data)
                ]
            );

            return new Markup($html, 'UTF-8');
        }

        return $renderer->render($action, $data);
    }

    protected function getActionRenderer(ActionInterface $action): ActionRenderInterface
    {
        return $this->container->get('action_renderers')->get($action->getRenderer());
    }
}