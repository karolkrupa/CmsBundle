<?php

namespace Devster\CmsBundle\Crud\List\Action;

use Devster\CmsBundle\Crud\List\Action\Renderer\ActionRenderer;

class Action implements ActionInterface
{
    const COLOR_DEFAULT = null;
    const COLOR_BLUE = 'BLUE';
    const COLOR_RED = 'RED';
    const COLOR_GREEN = 'GREEN';

    protected ?string $template = null;
    protected ?string $color = self::COLOR_DEFAULT;
    protected ?string $class = null;
    protected bool $appendClass = false;

    /**
     * @param string|Closure(mixed $data):string $text
     */
    public function __construct(
        protected string|\Closure $text
    )
    {
    }

    static public function create(string|\Closure $text = null): static
    {
        return new static($text);
    }

    /**
     * Konfiguracja nazwy akcji
     *
     * @param string|Closure(mixed $data):string $text
     * @return $this
     */
    public function setText(string|\Closure $text): static
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Konfiguracja szablonu akcji
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
     * Konfiguracja koloru akcji
     *
     * @param string|null $color
     * @return $this
     */
    public function setColor(?string $color): static
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Konfiguracja klas
     *
     * @param string|null $class
     * @param bool $appendClass
     * @return $this
     */
    public function setClass(?string $class, bool $appendClass = false): static
    {
        $this->class = $class;
        $this->appendClass = $appendClass;

        return $this;
    }


    public function getText(): null|string|\Closure
    {
        return $this->text;
    }

    public function getRenderer(): string
    {
        return ActionRenderer::class;
    }

    public function getTemplate(): string
    {
        if ($this->template) {
            return $this->template;
        }

        return '@DevsterCms/common/button/text/default.html.twig';
    }

    public function getClass(): ?string
    {
        return $this->class;
    }

    public function isAppendClass(): bool
    {
        return $this->appendClass;
    }
}