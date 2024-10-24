<?php

namespace Devster\CmsBundle\Form;

use Devster\CmsBundle\Form\FilePond\FilePondType;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * @deprecated
 *
 * @see FilePondType new_file_callback option
 */
class ImageSubmittedEvent extends Event
{
    public function __construct(
        private mixed $mediaId,
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

    public function getOptions(): array
    {
        return $this->options;
    }
}