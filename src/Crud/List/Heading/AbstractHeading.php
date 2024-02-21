<?php

namespace Devster\CmsBundle\Crud\List\Heading;


abstract class AbstractHeading implements HeadingInterface
{
    protected bool $center = false;
    protected bool $bold = false;
    protected string $align = 'left';

    public function __construct(
        protected string  $text
    )
    {
    }

    static public function create(string $text): static
    {
        return new static($text);
    }

    /**
     * Konfiguracja wycentrowania tekstu w nagłówku
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
     * Konfiguracja pogrubienia tekstu na nagłówku
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
     * Konfiguracja wyjustowania nagłówku
     *
     * @param string $align
     * @return $this
     */
    public function setAlign(string $align = 'left'): static
    {
        $this->align = $align;

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
}