<?php

namespace Devster\CmsBundle\Crud\List\Action;

use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
use Twig\Markup;

#[AutoconfigureTag(name: 'devster.cms.renderer.action')]
class ConfirmationActionRenderer extends AnchorActionRenderer
{
    public function renderPageView(ActionInterface $action): Markup
    {
        if (!$action instanceof ConfirmationAction) {
            throw new \RuntimeException('Nieobsługiwany typ akcji: ' . get_class($action));
        }

        $template = $action->getTemplate('page') ?? '@DevsterCms/common/button/button.html.twig';

        return $this->render($action, null, $template);
    }

    public function renderCellView(ActionInterface $action, mixed $data): Markup
    {
        if (!$action instanceof ConfirmationAction) {
            throw new \RuntimeException('Nieobsługiwany typ akcji: ' . get_class($action));
        }

        $template = $action->getTemplate() ?? '@DevsterCms/common/button/text/text_button.html.twig';

        return $this->render($action, $data, $template);
    }

    public function renderDropdownView(ActionInterface $action, mixed $data)
    {
        if (!$action instanceof ConfirmationAction) {
            throw new \RuntimeException('Nieobsługiwany typ akcji: ' . get_class($action));
        }

        $template = $action->getTemplate('dropdown') ?? '@DevsterCms/common/button/text/text_button.html.twig';

        return $this->render($action, $data, $template);
    }


    private function render(ConfirmationAction $action, mixed $data, string $template): Markup
    {
        $url = $this->getActionUrl($action, $data);

        $html = $this->twig->render('@DevsterCms/crud/list/action/confirmation_action.html.twig', [
            'href' => $url,
            'buttonTemplate' => $template,
            'buttonText' => $action->getName(),
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