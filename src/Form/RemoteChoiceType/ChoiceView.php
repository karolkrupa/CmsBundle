<?php

namespace Devster\CmsBundle\Form\RemoteChoiceType;

class ChoiceView implements \JsonSerializable
{
    public function __construct(
        public readonly string $label,
        public readonly string $value,
        public readonly array $data = []
    )
    {
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'label' => $this->label,
            'value' => $this->value,
            'data' => (object)$this->data
        ];
    }
}