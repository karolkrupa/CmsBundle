<?php

namespace Devster\CmsBundle\Crud\Common\TemplatePage;

use Devster\CmsBundle\Crud\PagePayloadInterface;

class TemplatePagePayload implements PagePayloadInterface
{
    public function __construct(
        public readonly array $params
    )
    {
    }

    public function getPayload(): array
    {
        return $this->params;
    }

}