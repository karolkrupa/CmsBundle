<?php

namespace Devster\CmsBundle\Crud\List\Action;


use Devster\CmsBundle\Crud\List\Action\Renderer\ConfirmationActionRenderer;

/**
 * Action with confirmation modal
 */
class ConfirmationAction extends AnchorAction
{
    const TYPE_ANCHOR = 'anchor';
    const TYPE_BUTTON = 'button';
    const TYPE_TEXT_BUTTON = 'text_button';

    protected string $activatorType = self::TYPE_ANCHOR;
    protected null|string|\Closure $modalTitle = null;
    protected null|string|\Closure $modalText = '';
    protected string $acceptText = 'Tak';
    protected string $rejectText = 'Nie';

    /**
     * Configure modal title
     *
     * @param string|\Closure(mixed $data):string|null $modalTitle
     * @return $this
     */
    public function setModalTitle(string|\Closure|null $modalTitle): static
    {
        $this->modalTitle = $modalTitle;

        return $this;
    }

    /**
     * Configure modal text
     *
     * @param string|\Closure(mixed $data):string|null $modalText
     * @return $this
     */
    public function setModalText(string|\Closure|null $modalText): static
    {
        $this->modalText = $modalText;

        return $this;
    }

    /**
     * Configure confirm button text
     *
     * @param string $acceptText
     * @return $this
     */
    public function setAcceptText(string $acceptText): static
    {
        $this->acceptText = $acceptText;

        return $this;
    }

    /**
     * Configure reject button text
     *
     * @param string $rejectText
     * @return $this
     */
    public function setRejectText(string $rejectText): static
    {
        $this->rejectText = $rejectText;

        return $this;
    }

    /**
     * Configure activator button type
     *
     * available options:
     * - self::TYPE_ANCHOR @see AnchorAction
     * - self::TYPE_BUTTON @see ButtonAction
     * - self::TYPE_TEXT_BUTTON @see TextButtonAction
     *
     * @param string $activatorType
     * @return $this
     */
    public function setActivatorType(string $activatorType): ConfirmationAction
    {
        $this->activatorType = $activatorType;

        return $this;
    }

    public function getModalTitle(): string|\Closure|null
    {
        return $this->modalTitle;
    }

    public function getModalText(): string|\Closure|null
    {
        return $this->modalText;
    }

    public function getAcceptText(): string
    {
        return $this->acceptText;
    }

    public function getRejectText(): string
    {
        return $this->rejectText;
    }

    public function getRenderer(): string
    {
        return ConfirmationActionRenderer::class;
    }

    public function getTemplate(): string
    {
        if ($this->template) {
            return $this->template;
        }

        if ($this->activatorType == self::TYPE_ANCHOR) {
            $map = AnchorAction::TEMPLATES;
        } elseif ($this->activatorType == self::TYPE_BUTTON) {
            $map = ButtonAction::TEMPLATES;
        } elseif ($this->activatorType == self::TYPE_TEXT_BUTTON) {
            $map = TextButtonAction::TEMPLATES;
        } else {
            throw new \RuntimeException('Niznany typ aktywatora');
        }

        if (!isset($map[$this->color])) {
            throw new \RuntimeException('Brak templatki dla koloru akcji: ' . $this->color);
        }

        return $map[$this->color];
    }
}