<?php

namespace Devster\CmsBundle\Crud\List\Action;


class ConfirmationAction extends AnchorAction
{
    public function getRenderer(): string
    {
        return ConfirmationActionRenderer::class;
    }

    protected null|string|\Closure $modalTitle = null;
    protected null|string|\Closure $modalText = '';
    protected string $acceptText = 'Tak';
    protected string $rejectText = 'Nie';

    public function getModalTitle(): string|\Closure|null
    {
        return $this->modalTitle;
    }

    public function modalTitle(string|\Closure|null $modalTitle): static
    {
        $this->modalTitle = $modalTitle;

        return $this;
    }

    public function getModalText(): string|\Closure|null
    {
        return $this->modalText;
    }

    public function modalText(string|\Closure|null $modalText): static
    {
        $this->modalText = $modalText;

        return $this;
    }

    public function getAcceptText(): string
    {
        return $this->acceptText;
    }

    public function acceptText(string $acceptText): static
    {
        $this->acceptText = $acceptText;

        return $this;
    }

    public function getRejectText(): string
    {
        return $this->rejectText;
    }

    public function rejectText(string $rejectText): static
    {
        $this->rejectText = $rejectText;

        return $this;
    }
}