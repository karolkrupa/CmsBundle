<?php

namespace Devster\CmsBundle\Crud\List\Action;

use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
use Twig\Environment;
use Twig\Markup;

#[AutoconfigureTag(name: 'devster.cms.renderer.action')]
class ActionRenderer implements ActionRenderInterface
{
    public function __construct(
        private readonly Environment $twig
    )
    {
    }

    public function renderPageView(ActionInterface $action)
    {
        return $this->renderCellView($action, null);
    }


    public function renderCellView(ActionInterface $action, mixed $data)
    {
        $template = $action->getTemplate() ?? '@DevsterCms/crud/list/action/action.html.twig';

        $html = $this->twig->render($template, [
            'text' => $action->getName()
        ]);

        return new Markup($html, 'UTF-8');
    }

    public function renderDropdownView(ActionInterface $action, mixed $data)
    {
        $template = $action->getTemplate('dropdown') ?? '@DevsterCms/common/dropdown/item.html.twig';

        $html = $this->twig->render($template, [
            'text' => $action->getName()
        ]);

        return new Markup($html, 'UTF-8');
    }


}