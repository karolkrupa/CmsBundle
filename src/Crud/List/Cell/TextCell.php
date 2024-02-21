<?php

namespace Devster\CmsBundle\Crud\List\Cell;


use Devster\CmsBundle\Crud\List\Cell\Renderer\TextCellRenderer;

/**
 * Dto wartości komórki tabeli
 */
class TextCell extends AbstractCell implements TitledCellInterface
{
    protected string $align = 'left';
    protected null|string|\Closure $title = null;

    protected function getDefaultTemplate(): string
    {
        return '@DevsterCms/crud/list/cell/text.html.twig';
    }

    public function __construct(protected null|string|\Closure $value = null)
    {
    }

    static public function create(string|\Closure $value): static
    {
        return new static($value);
    }


    /**
     * Konfiguracja wyjustowania tekstu w komórce tabeli
     *
     * @param string $align
     * @return $this
     */
    public function setAlign(string $align = 'left'): static
    {
        $this->align = $align;

        return $this;
    }

    /**
     * Konfiguracja tytułu (popup) komórki tabeli
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
     * Konfiguracja danych przekazywanych do widoku komórki
     *
     * @param string|\Closure(mixed $cellData):mixed $value
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

    public function getAlign(): string
    {
        return $this->align;
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