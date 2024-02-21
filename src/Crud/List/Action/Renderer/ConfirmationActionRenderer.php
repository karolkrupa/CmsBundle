<?php

namespace Devster\CmsBundle\Crud\List\Action\Renderer;

use Devster\CmsBundle\Crud\List\Action\ActionInterface;
use Devster\CmsBundle\Crud\List\Action\ConfirmationAction;
use Twig\Markup;

class ConfirmationActionRenderer extends AnchorActionRenderer
{
    public function render(ActionInterface $action, mixed $data): Markup
    {
        if (!$action instanceof ConfirmationAction) {
            throw new \RuntimeException('Nieobsługiwany typ akcji');
        }

        $url = $this->getActionUrl($action, $data);

        $template = $action->getTemplate() ?? '@DevsterCms/common/button/text/default.html.twig';

        $html = $this->twig()->render('@DevsterCms/crud/list/action/confirmation_action.html.twig', [
            ...$this->getViewData($action, $data),
            'href' => $url,
            'buttonTemplate' => $template,
            'buttonText' => $action->getText() instanceof \Closure ? $action->getText()($data) : $action->getText(),
            'modalArguments' => $this->parseModalData($action, $data),
            'modalId' => 'modal-' . uniqid()
        ]);

        return new Markup($html, 'UTF-8');
    }

    private function parseModalData(ConfirmationAction $action, mixed $data): array
    {
        if ($title = $action->getModalTitle() instanceof \Closure) {
            $title = $action->getModalTitle()($data);
        }

        if ($text = $action->getModalText() instanceof \Closure) {
            $text = $action->getModalText()($data);
        }

        return [
            'title' => $title,
            'text' => $text,
            'acceptText' => $action->getAcceptText(),
            'rejectText' => $action->getRejectText()
        ];
    }
}