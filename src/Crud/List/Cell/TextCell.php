<?php

namespace Devster\CmsBundle\Crud\List\Cell;


use Devster\CmsBundle\Crud\Common\View\PageViewContextInterface;
use Devster\CmsBundle\Crud\List\Cell\Renderer\TextCellRenderer;

/**
 * Text cell
 */
class TextCell extends AbstractCell implements TitledCellInterface
{
    protected string $align = 'left';
    protected null|string|\Closure $title = null;

    public function __construct(protected null|string|\Closure $value = null)
    {
    }

    static public function create(string|\Closure $value): static
    {
        return new static($value);
    }

    protected function getDefaultTemplate(): string
    {
        return '@DevsterCms/crud/list/cell/text.html.twig';
    }


    /**
     * Configure cell html title
     *
     * @param string|\Closure|null $title
     * @return $this
     */
    public function setTitle(string|\Closure|null $title): static
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Configure text value
     *
     * Always dynamically configures the value for the provided data (cell data).
     * - If it is string, evaluates value using the possible getters
     * - If it is a closure, the value returned from the closure will be used
     *
     * @param string|\Closure(mixed $cellData, PageViewContextInterface $context):mixed $value
     * @return $this
     */
    public function setValue(string|\Closure $value): static
    {
        $this->value = $value;

        return $this;
    }

    public function getValue(): null|string|\Closure
    {
        return $this->value;
    }

    public function getTitle(): string|\Closure|null
    {
        return $this->title;
    }

    /**
     * Zmienne dla widoku
     *
     * @param mixed $data
     * @return \Closure[]|null[]|string[]
     */
    public function getViewVars(mixed $data): array
    {
        return [
            'title' => $this->title instanceof \Closure ? ($this->title)($data) : $this->title
        ];
    }

    public function getRenderer(): string
    {
        return TextCellRenderer::class;
    }
}