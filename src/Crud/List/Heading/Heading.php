<?php

namespace Devster\CmsBundle\Crud\List\Heading;

use Devster\CmsBundle\Crud\List\Heading\Renderer\HeadingRenderer;

/**
 * Dto nagłówka kolumny tabeli
 */
class Heading extends AbstractHeading
{
    public function getRenderer(): string
    {
        return HeadingRenderer::class;
    }

    public function text(string $text): static
    {
        $this->text = $text;

        return $this;
    }

    public function getText(): string
    {
        return $this->text;
    }
}