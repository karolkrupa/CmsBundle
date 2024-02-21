<?php

namespace Devster\CmsBundle\Crud\List\Cell;

abstract class AbstractCell implements CellInterface
{
    protected ?string $template = null;
    protected bool $center = false;
    protected bool $bold = false;


    /**
     * Konfiguracja szablonu widoku
     *
     * @param string|null $template
     * @return $this
     */
    public function setTemplate(?string $template): static
    {
        $this->template = $template;

        return $this;
    }

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

    public function getTemplate(): ?string
    {
        return $this->template;
    }

    public function getCenter(): bool
    {
        return $this->center;
    }

    public function getBold(): bool
    {
        return $this->bold;
    }

    /**
     * Zmienne dla widoku
     *
     * @param mixed $data
     * @return array
     */
    public function getViewVars(mixed $data): array
    {
        return [];
    }
}