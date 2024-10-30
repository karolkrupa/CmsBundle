<?php

namespace Devster\CmsBundle\Form\FilePond;

class FileDto
{
    public function __construct(
        public string $id,
        public string $name,
        public ?int $size,
        public ?string $mimeType,
        public ?string $previewUrl = null
    )
    {
        parent::__construct($id);
    }
}