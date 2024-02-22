<?php

namespace Devster\CmsBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ServiceLocator;

class CrudPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        $listFieldRenderers = $container->findTaggedServiceIds('devster_cms.crud.list.field.renderer');

        $tagged = [];
        foreach ($listFieldRenderers as $key => $value) {
            $tagged[$key] = new Reference($key);
        }

        $locator = (new Definition(ServiceLocator::class))
            ->addArgument($tagged)
            ->addTag('container.service_locator');

        $container->setDefinition('devster_cms.crud.list.field.renderer_locator', $locator);

        $tagged = [];
        foreach ($container->findTaggedServiceIds('devster.cms.renderer.page') as $key => $value) {
            $tagged[$key] = new Reference($key);
        }

        $locator = (new Definition(ServiceLocator::class))
            ->addArgument($tagged)
            ->addTag('container.service_locator');

        $container->setDefinition('devster.cms.renderer.page.locator', $locator);

    }

}