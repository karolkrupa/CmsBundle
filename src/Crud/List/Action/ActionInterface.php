<?php

namespace Devster\CmsBundle\Crud\List\Action;

use Devster\CmsBundle\Crud\List\Action\Renderer\ActionRenderer;

interface ActionInterface
{
    /**
     * @param string|Closure(mixed $data):string $text
     */
    public function __construct(string|\Closure $text);

    /**
     * Konfiguracja nazwy akcji
     *
     * @param string|Closure(mixed $data):string $text
     * @return $this
     */
    public function setText(string|\Closure $text): static;

    /**
     * Konfiguracja szablonu akcji
     *
     * @param string|null $template
     * @return $this
     */
    public function setTemplate(?string $template): static;

    /**
     * Konfiguracja koloru akcji
     *
     * @param string|null $color
     * @return $this
     */
    public function setColor(?string $color): static;

    /**
     * Konfiguracja klas
     *
     * @param string|null $class
     * @param bool $appendClass
     * @return $this
     */
    public function setClass(?string $class, bool $appendClass = false): static;


    public function getText(): null|string|\Closure;

    public function getRenderer(): string;

    public function getTemplate(): string;

    public function getClass(): ?string;

    public function isAppendClass(): bool;
}