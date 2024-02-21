<?php

namespace Devster\CmsBundle\Crud\List\Heading;

interface HeadingInterface
{
    public function getRenderer(): string;

    public function setBold(bool $bold = true);
    public function setAlign(string $align = 'left');
}