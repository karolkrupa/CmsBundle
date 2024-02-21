<?php

namespace Devster\CmsBundle\Crud\List\Action;

use Devster\CmsBundle\Crud\List\Action\Renderer\ActionRenderer;

class Action implements ActionInterface
{
    const COLOR_DEFAULT = null;
    const COLOR_BLUE = 'BLUE';
    const COLOR_RED = 'RED';
    const COLOR_GREEN = 'GREEN';
    const TYPE_DEFAULT = 'default';
    const TYPE_TEXT = 'text';
    const TYPE_BUTTON = 'button';

    protected ?string $template = null;
    protected ?string $color = self::COLOR_DEFAULT;
    protected string $type = self::TYPE_DEFAULT;

    public function __construct(
        protected string $name
    )
    {
    }

    static public function create(string $name): static
    {
        return new static($name);
    }

    /**
     * Konfiguracja nazwy akcji
     *
     * @param string $name
     * @return $this
     */
    public function setName(string $name): static
    {
        $this->name = $name;

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


    public function getName(): string
    {
        return $this->name;
    }
    public function getRenderer(): string
    {
        return ActionRenderer::class;
    }

    public function getTemplate(string $placeType = 'cell'): ?string
    {
        $mapText = [
            null => '@DevsterCms/common/button/text/text_button.html.twig',
            self::COLOR_BLUE => '@DevsterCms/common/button/text/text_button_blue.html.twig',
            self::COLOR_RED => '@DevsterCms/common/button/text/text_button_red.html.twig',
            self::COLOR_GREEN => '@DevsterCms/common/button/text/text_button_green.html.twig'
        ];

        $mapButton = [
            null => '@DevsterCms/common/button/button.html.twig',
            self::COLOR_BLUE => '@DevsterCms/common/button/button_blue.html.twig',
            self::COLOR_RED => '@DevsterCms/common/button/button_red.html.twig',
            self::COLOR_GREEN => '@DevsterCms/common/button/button_green.html.twig'
        ];

        if ($this->template) {
            return $this->template;
        }

        $type = $this->type;
        if ($type == self::TYPE_DEFAULT) {
            if($placeType == 'dropdown') {
                return '@DevsterCms/common/dropdown/item.html.twig';
            }

            $type = $placeType == 'cell' ? self::TYPE_TEXT : self::TYPE_BUTTON;
        }
        $map = $type == self::TYPE_TEXT ? $mapText : $mapButton;

        if (!isset($map[$this->color])) {
            throw new \RuntimeException('Brak templatki dla koloru akcji: ' . $this->color);
        }

        return $map[$this->color];
    }
}