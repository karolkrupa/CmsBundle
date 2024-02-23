<?php

namespace Devster\CmsBundle\Crud\Common\View;

use Devster\CmsBundle\Crud\Common\RenderableInterface;
use Devster\CmsBundle\Crud\Common\TemplateableInterface;

/**
 * Interface for page views
 */
interface PageViewInterface extends TemplateableInterface, RenderableInterface
{
    /**
     * Handler that should handle this page view
     *
     * @return string - handler class FQN
     */
    public function getHandler(): string;

    /**
     * Page title
     *
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title): static;

    public function getTitle(): string;
}