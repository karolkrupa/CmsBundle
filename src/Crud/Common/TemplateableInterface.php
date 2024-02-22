<?php

namespace Devster\CmsBundle\Crud\Common;

interface TemplateableInterface
{
    public function setTemplate(?string $template): static;

    public function getTemplate(): ?string;
}