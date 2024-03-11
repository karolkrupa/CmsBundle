<?php

namespace Devster\CmsBundle\Crud\Common\View;

use Devster\CmsBundle\Crud\Common\View\PageViewPayloadInterface;

/** @deprecated  */
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