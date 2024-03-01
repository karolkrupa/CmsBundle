<?php

namespace Devster\CmsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('devster_cms');

        $treeBuilder->getRootNode()
            ->children()
                ->scalarNode('encore_entry')->defaultNull()->end()
                ->arrayNode('dashboard')
                    ->children()
                        ->scalarNode('title')->defaultValue('Dashboard')->end()
                        ->scalarNode('my_account_route')->defaultNull()->end()
                        ->scalarNode('logout_route')->defaultNull()->end()
                    ->end()->addDefaultsIfNotSet()
                ->end()
                ->scalarNode('sidebar_config_file')->defaultValue('config/sidebar.yaml')->end()
                ->arrayNode('ckeditor')
                    ->children()
                        ->scalarNode('file_upload_route')->defaultNull()->end()
                    ->end()->addDefaultsIfNotSet()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }

}