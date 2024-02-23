<?php

namespace Devster\CmsBundle\Crud\Common\View;

/**
 * Interface for page view payload objects
 */
interface PageViewPayloadInterface
{
    /**
     * Returns the payload for the view
     *
     * @return mixed
     */
    public function getPayload(): mixed;
}