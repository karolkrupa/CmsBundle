<?php

namespace Devster\CmsBundle\Crud\List\Action;


use Devster\CmsBundle\Crud\List\Action\Renderer\ConfirmationActionRenderer;

class ConfirmationAction extends AnchorAction
{
    protected null|string|\Closure $modalTitle = null;
    protected null|string|\Closure $modalText = '';
    protected string $acceptText = 'Tak';
    protected string $rejectText = 'Nie';

    /**
     * Konfiguracja tytułu modala
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
     * Konfiguracja tekstu modala
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
     * Konfiguracja tekstu przycisku akceptacji
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
     * Konfiguracja treści przycisku odrzucenia
     *
     * @param string $rejectText
     * @return $this
     */
    public function setRejectText(string $rejectText): static
    {
        $this->rejectText = $rejectText;

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
}