<?php

namespace Devster\CmsBundle\Crud\Delete;

use Devster\CmsBundle\Crud\Common\Page\PageResultHandlerInterface;
use Devster\CmsBundle\Crud\Common\View\PageViewInterface;
use Devster\CmsBundle\Crud\PageConfigInterface;
use Devster\CmsBundle\Crud\PageHandlerInterface;
use Devster\CmsBundle\Crud\PageInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class DeletePageConfig implements PageConfigInterface
{
    protected ?DeletePageView $view = null;
    protected EventDispatcherInterface $eventDispatcher;
    protected ?string $successMessage = null;
    protected ?PageResultHandlerInterface $successHandler = null;

    public function __construct(
        protected readonly PageHandlerInterface $handler
    )
    {
        $this->eventDispatcher = new EventDispatcher();
    }

    public function getSuccessMessage(): ?string
    {
        return $this->successMessage;
    }

    public function setSuccessMessage(?string $successMessage): static
    {
        $this->successMessage = $successMessage;

        return $this;
    }

    public function getSuccessHandler(): ?PageResultHandlerInterface
    {
        return $this->successHandler;
    }

    public function setSuccessHandler(?PageResultHandlerInterface $successHandler): static
    {
        $this->successHandler = $successHandler;

        return $this;
    }

    public function getView(): DeletePageView
    {
        if (!$this->view) {
            $this->view = new DeletePageView();
        }

        return $this->view;
    }

    public function setView(PageViewInterface $view): static
    {
        if (!$view instanceof DeletePageView) {
            throw new \RuntimeException('instance of DeletePageView expected');
        }

        $this->view = $view;

        return $this;
    }

    public function getPage(): PageInterface
    {
        return new DeletePage($this, $this->handler);
    }

    public function getDispatcher(): EventDispatcherInterface
    {
        return $this->eventDispatcher;
    }
}