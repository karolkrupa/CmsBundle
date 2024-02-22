<?php

namespace Devster\CmsBundle\Crud\Common\View;

use Devster\CmsBundle\Crud\Common\Renderer\TemplatePageViewRenderer;

class TemplatePageView implements PageViewInterface
{
    protected ?string $title = null;
    protected ?string $template = null;

    public function getRenderer(): string
    {
        return TemplatePageViewRenderer::class;
    }

    public function getHandler(): string
    {
        return TemplatePageViewHandler::class;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function setTemplate(?string $template): static
    {
        $this->template = $template;

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getTemplate(): ?string
    {
        return $this->template;
    }
}