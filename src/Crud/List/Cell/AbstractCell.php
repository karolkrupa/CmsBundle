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
     * @param string|null $template
     * @return $this
     */
    public function setTemplate(?string $template): static
    {
        $this->template = $template;

        return $this;
    }

    /**
     * @param Alignment $alignment
     * @return $this
     */
    public function setAlignment(Alignment $alignment): static
    {
        $this->alignment = $alignment;

        return $this;
    }

    /**
     * @param VerticalAlignment $alignment
     * @return $this
     */
    public function setVerticalAlignment(VerticalAlignment $alignment): static
    {
        $this->verticalAlignment = $alignment;

        return $this;
    }

    /**
     * @param bool $bold
     * @return $this
     */
    public function setBold(bool $bold = true): static
    {
        $this->bold = $bold;

        return $this;
    }

    /**
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