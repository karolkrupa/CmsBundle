<?php

namespace Devster\CmsBundle\Crud\List\Action;

use Devster\CmsBundle\Crud\Common\RenderableInterface;
use Devster\CmsBundle\Crud\Common\TemplateableInterface;

interface ActionInterface extends TemplateableInterface, RenderableInterface
{
    /**
     * @see ActionInterface::setText
     *
     * @param string|Closure(mixed $data):string $text
     */
    public function __construct(string|\Closure $text);

    /**
     * Configure action text
     *
     * It sets text explicitly or dynamically by closure.
     * Dynamic text is only available in table cells
     *
     * @param string|Closure(mixed $data):string $text
     * @return $this
     */
    public function setText(string|\Closure $text): static;

    /**
     * Configure color variant
     *
     * @param string|null $color
     * @return $this
     */
    public function setColor(?string $color): static;

    /**
     * Configure html classes
     *
     * @param string|null $class
     * @param bool $appendClass
     * @return $this
     */
    public function setClass(?string $class, bool $appendClass = false): static;

    public function getText(): null|string|\Closure;

    public function getClass(): ?string;

    public function isAppendClass(): bool;
}