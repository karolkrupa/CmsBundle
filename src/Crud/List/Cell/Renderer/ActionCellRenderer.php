<?php

namespace Devster\CmsBundle\Crud\List\Cell\Renderer;

use Devster\CmsBundle\Crud\List\Cell\ActionCell;
use Devster\CmsBundle\Crud\List\Cell\CellInterface;
use Symfony\Component\DependencyInjection\Attribute\TaggedLocator;
use Symfony\Component\DependencyInjection\ServiceLocator;
use Twig\Markup;

class ActionCellRenderer extends AbstractCellRenderer
{
    public function __construct(
        #[TaggedLocator(tag: 'devster.cms.renderer.action')]
        private readonly ServiceLocator $actionsRendererLocator,
    )
    {
    }

    public function render(CellInterface $cell, mixed $data): Markup
    {
        if (!$cell instanceof ActionCell) {
            throw new \RuntimeException('Nieznany typ komórki');
        }

        $action = $cell->getAction();

        $renderer = $this->actionsRendererLocator->get($action->getRenderer());

        if ($cell->getTemplate()) {
            $html = $this->twig()->render(
                $cell->getTemplate(),
                [
                    ...$this->getViewData($cell, $data),
                    'actionHtml' => $renderer->render($action, $data)
                ]
            );

            return new Markup($html, 'UTF-8');
        }

        return $renderer->render($action, $data);
    }
}