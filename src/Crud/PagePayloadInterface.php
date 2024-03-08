<?php

namespace Devster\CmsBundle\Crud;

/**
 * Interface for page view payload objects
 */
interface PagePayloadInterface
{
    /**
     * Returns the payload for the view
     *
     * @return mixed
     */
    public function getPayload(): mixed;
}