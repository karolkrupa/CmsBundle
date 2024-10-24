<?php

namespace Devster\CmsBundle\Form\FilePond;

class UploadedFileDto
{
    public function __construct(
        public string $id
    )
    {
    }
}