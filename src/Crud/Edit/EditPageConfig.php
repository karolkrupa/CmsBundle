<?php

namespace Devster\CmsBundle\Crud\Edit;

use Devster\CmsBundle\Crud\Common\View\PageViewInterface;
use Devster\CmsBundle\Crud\PageConfigInterface;
use Devster\CmsBundle\Crud\PageHandlerInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class EditPageConfig implements PageConfigInterface
{
    protected EventDispatcher $dispatcher;
    protected ?PageViewInterface $editView = null;
    protected ?string $successRoute = null;
    protected ?string $successMessage = null;
    protected ?string $errorMessage = null;

    public function __construct(protected readonly PageHandlerInterface $handler)
    {
        $this->dispatcher = new EventDispatcher();
    }

    public function getView(): EditView
    {
        if (!$this->editView) {
            $this->editView = new EditView();
        }

        return $this->editView;
    }

    public function setView(PageViewInterface $view): static
    {
        $this->editView = $view;

        return $this;
    }

    public function setSuccessRoute(string $routeName): static
    {
        $this->successRoute = $routeName;

        return $this;
    }

    public function getSuccessRoute(): ?string
    {
        return $this->successRoute;
    }

    public function setSuccessMessage(string $successMessage): static
    {
        $this->successMessage = $successMessage;

        return $this;
    }

    public function getSuccessMessage(): ?string
    {
        return $this->successMessage;
    }

    public function setErrorMessage(string $errorMessage): static
    {
        $this->errorMessage = $errorMessage;

        return $this;
    }

    public function getErrorMessage(): ?string
    {
        return $this->errorMessage;
    }

    public function getPage(): EditPage
    {
        return new EditPage(
            clone $this,
            $this->handler
        );
    }

    public function getDispatcher(): EventDispatcherInterface
    {
        return $this->dispatcher;
    }
}