<?php

namespace Devster\CmsBundle\Crud\Common;

/**
 * Interface for views that can use custom templates
 */
interface TemplateableInterface
{
    /**
     * Allows to set a custom twig template
     *
     * @param string|null $template
     * @return $this
     */
    public function setTemplate(?string $template): static;

    /**
     * @return string|null
     */
    public function getTemplate(): ?string;
}