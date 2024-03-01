<?php

namespace Devster\CmsBundle\Crud\List\Cell;


use Devster\CmsBundle\Crud\List\Cell\Renderer\BadgeCellRenderer;

/**
 * Text cell
 */
class BadgeCell extends TextCell
{
    const COLOR_GRAY = 'gray';
    const COLOR_LIGHTGRAY = 'lightgray';
    const COLOR_GREEN = 'green';
    const COLOR_BLUE = 'blue';
    const COLOR_RED = 'red';
    const COLOR_YELLOW = 'yellow';

    protected null|string|\Closure $color = null;

    public function getRenderer(): string
    {
        return BadgeCellRenderer::class;
    }


    protected function getDefaultTemplate(): string
    {
        return '@DevsterCms/common/badge/gray.html.twig';
    }

    public function setColor(null|string|\Closure $color): static
    {
        $this->color = $color;

        return $this;
    }

    public function getColor(): null|string|\Closure
    {
        return $this->color;
    }

    public function getTemplate(mixed $data = null): ?string
    {
        if(!$this->color && !$data) {
            return $this->getDefaultTemplate();
        }

        if(!$this->color instanceof \Closure) {
            return sprintf(
                "@DevsterCms/common/badge/%s.html.twig",
                $this->color
            );
        }

        return sprintf(
            "@DevsterCms/common/badge/%s.html.twig",
            ($this->color)($data)
        );
    }
}