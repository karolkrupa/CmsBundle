<?php

namespace Devster\CmsBundle\Crud\Common\Renderer;

use Devster\CmsBundle\Crud\Common\View\PageViewPayloadInterface;

class TemplatePageViewPayload implements PageViewPayloadInterface
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