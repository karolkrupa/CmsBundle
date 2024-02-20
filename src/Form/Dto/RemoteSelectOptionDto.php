<?php

namespace Devster\CmsBundle\Form\Dto;

class RemoteSelectOptionDto
{
    public function __construct(
        public string $label,
        public string $value,
        public string $id
    )
    {

    }
}