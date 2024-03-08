<?php

namespace Devster\CmsBundle\CKEditor\Event;

use Symfony\Contracts\EventDispatcher\Event;

class MediaProcessingEvent extends Event
{
    public function __construct(
        private mixed $mediaId,
        private mixed $src,
        private array $options = []
    )
    {
    }

    public function getMediaId(): mixed
    {
        return $this->mediaId;
    }

    public function setMediaId(mixed $mediaId): void
    {
        $this->mediaId = $mediaId;
    }

    public function getSrc(): mixed
    {
        return $this->src;
    }

    public function setSrc(mixed $src): void
    {
        $this->src = $src;
    }

    public function getOptions(): array
    {
        return $this->options;
    }
}