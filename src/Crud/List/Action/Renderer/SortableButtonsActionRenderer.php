<?php

namespace Devster\CmsBundle\Crud\List\Action\Renderer;

use Devster\CmsBundle\Crud\List\Action\ActionInterface;
use Devster\CmsBundle\Crud\List\Action\SortableButtonsAction;

class SortableButtonsActionRenderer extends AnchorActionRenderer
{
    protected function getViewData(ActionInterface $action, mixed $data): array
    {
        if (!$action instanceof SortableButtonsAction) {
            throw new \RuntimeException('Nieobsługiwany typ akcji');
        }

        return [
            'prevHref' => $this->getUrl(
                $action->getRoute(),
                $action->getRouteParams(),
                $data,
                [$action->getSortDirectionParam() => $action->getSortPreviousValue()]
            ),
            'nextHref' => $this->getUrl(
                $action->getRoute(),
                $action->getRouteParams(),
                $data,
                [$action->getSortDirectionParam() => $action->getSortNextValue()]
            )
        ];
    }
}