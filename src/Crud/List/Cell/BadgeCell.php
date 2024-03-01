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

    protected function getDefaultTemplate(): string
    {
        return '@DevsterCms/crud/list/cell/badge.html.twig';
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

    public function getViewVars(mixed $data): array
    {
        if ($this->color instanceof \Closure) {
            $template = sprintf(
                "@DevsterCms/common/badge/%s.html.twig",
                ($this->color)($data)
            );
        }elseif($this->color) {
            $template = sprintf(
                "@DevsterCms/common/badge/%s.html.twig",
                $this->color
            );
        }else {
            $template = '@DevsterCms/common/badge/gray.html.twig';
        }

        return [
            ...parent::getViewVars($data),
            'template' => $template
        ];
    }


}