<?php

namespace Devster\CmsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class SidebarConfiguration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('sidebar');

        $treeBuilder->getRootNode()
            ->arrayPrototype()
            ->children()
            ->scalarNode('name')->end()
            ->booleanNode('hidden')->defaultFalse()->end()
            ->arrayNode('elements')->arrayPrototype()
            ->children()
            ->scalarNode('name')->isRequired()->end()
            ->scalarNode('icon')->end()
            ->scalarNode('route')->end()
            ->arrayNode('elements')->arrayPrototype()
            ->children()
            ->scalarNode('name')->isRequired()->end()
            ->scalarNode('route')->isRequired()->end()
            ->end()
            ->end()
            ->end()
            ->end()
            ->end()
            ->end();

        return $treeBuilder;
    }

}