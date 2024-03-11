<?php

namespace Devster\CmsBundle\Crud\Common\TemplatePage;

use Devster\CmsBundle\Crud\Common\View\PageViewInterface;
use Devster\CmsBundle\Crud\Common\TemplatePage\TemplatePageView;
use Devster\CmsBundle\Crud\PageConfigInterface;
use Devster\CmsBundle\Crud\PageHandlerInterface;
use Devster\CmsBundle\Crud\PageInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class TemplatePageConfig implements PageConfigInterface
{
    protected ?TemplatePageView $view = null;
    protected EventDispatcherInterface $eventDispatcher;

    public function __construct(protected readonly PageHandlerInterface $handler)
    {
        $this->eventDispatcher = new EventDispatcher();
    }

    public function getPage(): PageInterface
    {
        return new TemplatePage(
            $this,
            $this->handler
        );
    }

    public function getView(): TemplatePageView
    {
        if (!$this->view) {
            $this->view = new TemplatePageView();
        }

        return $this->view;
    }

    public function setView(PageViewInterface $view): static
    {
        if (!$view instanceof TemplatePageView) {
            throw new \RuntimeException('View must be instance of TemplatePageView');
        }

        $this->view = $view;

        return $this;
    }

    public function getDispatcher(): EventDispatcherInterface
    {
        return $this->eventDispatcher;
    }
}