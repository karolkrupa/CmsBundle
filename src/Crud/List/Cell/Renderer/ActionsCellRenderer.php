<?php

namespace Devster\CmsBundle\Crud\List\Cell\Renderer;

use Devster\CmsBundle\Crud\List\Action\ActionRenderer;
use Devster\CmsBundle\Crud\List\Action\ActionRenderInterface;
use Devster\CmsBundle\Crud\List\Cell\ActionsCell;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
use Symfony\Component\DependencyInjection\Attribute\TaggedLocator;
use Symfony\Component\DependencyInjection\ServiceLocator;
use Twig\Environment;
use Twig\Markup;

#[AutoconfigureTag(name: 'devster.cms.renderer.cell')]
class ActionsCellRenderer
{
    public function __construct(
        private readonly Environment    $twig,
        #[TaggedLocator(tag: 'devster.cms.renderer.action')]
        private readonly ServiceLocator           $actionsRendererLocator,
    )
    {
    }

    public function render(ActionsCell $cell, mixed $data): Markup
    {
        $renderedActions = [];
        foreach ($cell->getActions() as $action) {
            /** @var ActionRenderInterface $renderer */
            $renderer = $this->actionsRendererLocator->get($action->getRenderer());
            if($cell->isDropdown()) {
                $renderedActions[] = $renderer->renderDropdownView($action, $data);
            }else {
                $renderedActions[] = $renderer->renderCellView($action, $data);
            }

        }

        $html = $this->twig->render('@DevsterCms/crud/list/cell/actions.html.twig', [
            'cell' => $cell,
            'actions' => $renderedActions
        ]);

        return new Markup($html, 'UTF-8');
    }
}