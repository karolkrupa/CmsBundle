<?php

namespace Devster\CmsBundle\Crud\List\Heading;

interface HeadingInterface
{
    public function getRenderer(): string;

    public function bold(bool $bold = true);
    public function align(string $align = 'left');
}