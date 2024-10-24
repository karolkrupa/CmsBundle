<?php

namespace Devster\CmsBundle\Form\Dto;

/**
 * @deprecated
 */
class ImageDto
{
    public function __toString(): string
    {
        return $this->id;
    }

    public function __construct(
        private readonly string $id,
        private readonly ?string $name,
        private readonly int $size = 0,
        private readonly ?string $mime = 'image/jpeg',
    )
    {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getSize(): int
    {
        return $this->size;
    }

    public function getMime(): ?string
    {
        return $this->mime;
    }
}