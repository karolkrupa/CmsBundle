<?php

namespace Devster\CmsBundle\Crud\List\Cell;

abstract class AbstractCell implements CellInterface
{
    protected bool $center = false;
    protected bool $bold = false;
    protected string $align = 'left';
    protected null|string|\Closure $title = null;

    /**
     * Konfiguracja wycentrowania w komórce tabeli
     *
     * @param bool $center
     * @return $this
     */
    public function setCenter(bool $center = true): static
    {
        $this->center = $center;

        return $this;
    }

    /**
     * Konfiguracja pogrubienia tekstu w komórce tabeli
     *
     * @param bool $bold
     * @return $this
     */
    public function setBold(bool $bold = true): static
    {
        $this->bold = $bold;

        return $this;
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

    public function getCenter(): bool
    {
        return $this->center;
    }

    public function getBold(): bool
    {
        return $this->bold;
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
}