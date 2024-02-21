<?php

namespace Devster\CmsBundle\Crud\List\Cell\Renderer;

use Devster\CmsBundle\Crud\List\Cell\AbstractCell;
use Devster\CmsBundle\Crud\List\Cell\CellInterface;
use Symfony\Contracts\Service\Attribute\SubscribedService;
use Symfony\Contracts\Service\ServiceSubscriberInterface;
use Symfony\Contracts\Service\ServiceSubscriberTrait;
use Twig\Environment;
use Twig\Markup;

abstract class AbstractCellRenderer implements CellRendererInterface, ServiceSubscriberInterface
{
    use ServiceSubscriberTrait;

    public function render(AbstractCell $cell, mixed $data): Markup
    {
        return $this->renderTemplate(
            $cell,
            $data,
            $cell->getTemplate()
        );
    }

    protected function renderTemplate(AbstractCell $cell, mixed $data, string $template): Markup
    {
        $html = $this->twig()->render(
            $template,
            $this->getViewData($cell, $data)
        );

        return new Markup($html, 'UTF-8');
    }

    protected function getViewData(AbstractCell $cell, mixed $data): array
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