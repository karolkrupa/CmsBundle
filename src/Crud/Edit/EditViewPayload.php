<?php

namespace Devster\CmsBundle\Crud\Edit;

use Devster\CmsBundle\Crud\Common\View\PageViewPayloadInterface;
use Symfony\Component\HttpFoundation\Request;

class EditViewPayload implements PageViewPayloadInterface
{
    public function __construct(
        public readonly Request $request,
        public readonly mixed   $data
    )
    {
    }

    /**
     * @return object{request: Request, data: mixed}
     */
    public function getPayload(): object
    {
        return (object)[
            'request' => $this->request,
            'data' => $this->data
        ];
    }

}