<?php

namespace Devster\CmsBundle\Crud\List;

use Devster\CmsBundle\Crud\Common\View\PageViewInterface;
use Devster\CmsBundle\Crud\PageConfigInterface;
use Devster\CmsBundle\Crud\PageHandlerInterface;
use Devster\CmsBundle\Crud\PageInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class ListPageConfig implements PageConfigInterface
{
    protected ?PageViewInterface $view = null;
    protected EventDispatcherInterface $dispatcher;

    public function __construct(protected readonly PageHandlerInterface $handler)
    {
        $this->dispatcher = new EventDispatcher();
    }

    public function getView(): ListPageView
    {
        if(!$this->view) {
            $this->view = new ListPageView();
        }

        return $this->view;
    }

    public function setView(PageViewInterface $view): static
    {
        $this->view = $view;

        return $this;
    }

    public function getPage(): PageInterface
    {
        return new ListPage(
            clone $this,
            $this->handler
        );
    }

    public function getDispatcher(): EventDispatcherInterface
    {
        return $this->dispatcher;
    }

}