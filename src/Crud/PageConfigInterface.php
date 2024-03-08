<?php

namespace Devster\CmsBundle\Crud;

use Devster\CmsBundle\Crud\Common\View\PageViewInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

interface PageConfigInterface
{
    public function __construct(PageHandlerInterface $handler);

    public function getView(): PageViewInterface;

    public function setView(PageViewInterface $view): static;

    public function getPage(): PageInterface;

    public function getDispatcher(): EventDispatcherInterface;
}