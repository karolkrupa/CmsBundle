<?php

namespace Devster\CmsBundle\Form\RemoteChoiceType;

use Psr\Container\ContainerInterface;
use Symfony\Component\DependencyInjection\Attribute\TaggedLocator;

class ChoiceProviderMap
{
    public function __construct(
        #[TaggedLocator('devster.remote.select.provider', defaultIndexMethod: 'getKey')]
        private readonly ContainerInterface $locator,
    )
    {
    }

    public function get(string $name)
    {
        return $this->locator->get($name);
    }
}