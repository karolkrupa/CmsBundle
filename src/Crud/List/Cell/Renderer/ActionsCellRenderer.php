<?php

namespace Devster\CmsBundle\Crud\List\Cell\Renderer;

use Devster\CmsBundle\Crud\Common\View\PageViewContextInterface;
use Devster\CmsBundle\Crud\List\Cell\ActionsCell;
use Devster\CmsBundle\Crud\List\Cell\CellInterface;
use Twig\Markup;

class ActionsCellRenderer extends ActionCellRenderer
{
    public function render(CellInterface $cell, mixed $data, PageViewContextInterface $context): Markup
    {
        if (!$cell instanceof ActionsCell) {
            throw new \RuntimeException('Niepoprawny typ akcji');
        }

        $renderedActions = [];
        foreach ($cell->getActions() as $action) {
            $renderer = $this->getActionRenderer($action);
            $renderedActions[] = $renderer->render($action, $data);
        }

        $html = $this->twig()->render('@DevsterCms/crud/list/cell/actions.html.twig', [
            'cell' => $cell,
            'actions' => $renderedActions
        ]);

        return new Markup($html, 'UTF-8');
    }
}