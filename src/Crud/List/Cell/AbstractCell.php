<?php

namespace Devster\CmsBundle\Crud\List\Cell;

use Devster\CmsBundle\Crud\Common\Alignment;
use Devster\CmsBundle\Crud\Common\VerticalAlignment;

abstract class AbstractCell implements CellInterface
{
    protected ?string $template = null;
    protected bool $bold = false;
    protected Alignment $alignment = Alignment::left;
    protected VerticalAlignment $verticalAlignment = VerticalAlignment::middle;
    protected ?string $class = null;

    abstract protected function getDefaultTemplate(): ?string;

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
     * Konfiguracja położenia w komórce tabeli
     *
     * @param Alignment $alignment
     * @return $this
     */
    public function setAlignment(Alignment $alignment): static
    {
        $this->alignment = $alignment;

        return $this;
    }

    /**
     * Konfiguracja położenia w komórce tabeli
     *
     * @param VerticalAlignment $alignment
     * @return $this
     */
    public function setVerticalAlignment(VerticalAlignment $alignment): static
    {
        $this->verticalAlignment = $alignment;

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
     * Konfiguracja dodatkowych klas dla komórki
     *
     * @param string|null $class
     * @return $this
     */
    public function setClass(?string $class): static
    {
        $this->class = $class;

        return $this;
    }

    public function getTemplate(): ?string
    {
        if ($this->template) {
            return $this->template;
        }

        return $this->getDefaultTemplate();
    }

    public function getBold(): bool
    {
        return $this->bold;
    }

    public function getClass(): ?string
    {
        return $this->class;
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

    public function getAlignment(): Alignment
    {
        return $this->alignment;
    }

    public function getVerticalAlignment(): VerticalAlignment
    {
        return $this->verticalAlignment;
    }
}