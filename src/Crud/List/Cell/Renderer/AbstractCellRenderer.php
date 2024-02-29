<?php

namespace Devster\CmsBundle\Crud\List\Cell\Renderer;

use Devster\CmsBundle\Crud\Common\View\PageViewContextInterface;
use Devster\CmsBundle\Crud\List\Cell\CellInterface;
use Symfony\Contracts\Service\Attribute\SubscribedService;
use Symfony\Contracts\Service\ServiceSubscriberInterface;
use Symfony\Contracts\Service\ServiceSubscriberTrait;
use Twig\Environment;
use Twig\Markup;

abstract class AbstractCellRenderer implements CellRendererInterface, ServiceSubscriberInterface
{
    use ServiceSubscriberTrait;

    public function render(CellInterface $cell, mixed $data, PageViewContextInterface $context): Markup
    {
        return $this->renderTemplate(
            $cell,
            $data,
            $cell->getTemplate(),
            $context
        );
    }

    protected function renderTemplate(CellInterface $cell, mixed $data, string $template, PageViewContextInterface $context): Markup
    {
        $html = $this->twig()->render(
            $template,
            $this->getViewData($cell, $data, $context)
        );

        return new Markup($html, 'UTF-8');
    }

    protected function getViewData(CellInterface $cell, mixed $data, PageViewContextInterface $context): array
    {
        return [
            'vars' => $cell->getViewVars($data)
        ];
    }

    #[SubscribedService]
    protected function twig(): Environment
    {
        return $this->container->get(__METHOD__);
    }
}