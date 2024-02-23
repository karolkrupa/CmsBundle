<?php

namespace Devster\CmsBundle\Crud\List\Cell;

use Devster\CmsBundle\Crud\Common\Alignment;
use Devster\CmsBundle\Crud\Common\RenderableInterface;
use Devster\CmsBundle\Crud\Common\TemplateableInterface;
use Devster\CmsBundle\Crud\Common\VerticalAlignment;

interface CellInterface extends TemplateableInterface, RenderableInterface
{
    /**
     * Return variables for view twig template
     *
     * @param mixed $data
     * @return array
     */
    public function getViewVars(mixed $data): array;

    /**
     * Configure html classes
     *
     * @param string|null $class
     * @return $this
     */
    public function setClass(?string $class): static;

    /**
     * Configure content horizontal alignment
     *
     * @param Alignment $alignment
     * @return $this
     */
    public function setAlignment(Alignment $alignment): static;

    /**
     * Configure content vertical alignment
     *
     * @param VerticalAlignment $alignment
     * @return $this
     */
    public function setVerticalAlignment(VerticalAlignment $alignment): static;

    /**
     * Configure font boldness
     *
     * @param bool $bold
     * @return $this
     */
    public function setBold(bool $bold = true): static;

    public function getAlignment(): Alignment;

    public function getVerticalAlignment(): VerticalAlignment;

    public function getBold(): bool;
}