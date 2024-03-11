<?php

namespace Devster\CmsBundle\Crud\Delete;

use Devster\CmsBundle\Crud\Common\View\PageViewInterface;

class DeletePageView implements PageViewInterface
{
    public function getHandler(): string
    {
        return '';
    }

    public function setTitle(string $title): static
    {
        return $this;
    }

    public function getTitle(): string
    {
        return '';
    }

    public function getRenderer(): string
    {
        return '';
    }

    public function setTemplate(?string $template): static
    {
        return $this;
    }

    public function getTemplate(): ?string
    {
        return null;
    }
}