<?php

namespace Devster\CmsBundle\Crud\Sidebar;

use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Config\ConfigCache;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Yaml\Yaml;

class Sidebar
{
    private ?array $config = null;

    public function __construct(
        private readonly string                $sidebarConfigFile,
        private readonly ParameterBagInterface $parameters,
        private readonly UrlGeneratorInterface $urlGenerator,
        private readonly Security              $security
    )
    {
    }

    public function getConfig(): array
    {
        if (!file_exists($this->sidebarConfigFile)) {
            return [
                'sidebar' => [],
                'routeMap' => []
            ];
        }

        $configCache = new ConfigCache($this->getCacheFilepath(), $this->parameters->get('kernel.environment') === 'dev');

        if (!$configCache->isFresh()) {
            $menuConfig = Yaml::parseFile($this->sidebarConfigFile);

            $menuConfig = $this->getConfigTreeBuilder()->buildTree()->normalize($menuConfig['sidebar']);

            $config = [];
            $config['sidebar'] = $this->parseConfig($menuConfig);
            $config['routeMap'] = $this->generateRouteMap($config['sidebar']);

            $configCache->write(serialize($config), [new FileResource($this->sidebarConfigFile)]);

            $this->config = null;
        }

        if ($this->config !== null) {
            return $this->config;
        }

        return $this->config = unserialize(file_get_contents($configCache->getPath()));
    }

    private function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('sidebar');

        // @formatter:off
        $treeBuilder->getRootNode()
            ->arrayPrototype()
            ->children()
            ->scalarNode('name')->end()
            ->booleanNode('label_hidden')->defaultFalse()->end()
            ->arrayNode('elements')
            ->arrayPrototype()
            ->children()
            ->scalarNode('name')->isRequired()->end()
            ->scalarNode('icon')->end()
            ->scalarNode('route')->end()
            ->arrayNode('roles')
            ->scalarPrototype()->end()
            ->end()
            ->arrayNode('elements')
            ->arrayPrototype()
            ->children()
            ->scalarNode('name')->isRequired()->end()
            ->scalarNode('route')->isRequired()->end()
            ->arrayNode('roles')
            ->scalarPrototype()->end()
            ->end()
            ->end()
            ->end()
            ->end()
            ->end()
            ->end()
            ->end();
        // @formatter:off

        return $treeBuilder;
    }

    private function parseConfig(array $elements, $prefix = null): array
    {
        $parsedConfig = [];

        foreach ($elements as $idx => $element) {
            $elementId = $prefix !== null ? $prefix . '_' . $idx : $idx;

            $elementConfig = [
                'id' => $elementId,
                'name' => $element['name'],
                'route' => isset($element['route'])? $element['route'] : null,
                'slug' => md5($elementId),
                'roles' => $element['roles'] ?? []
            ];

            if(isset($element['label_hidden'])) {
                $elementConfig['label_hidden'] = $element['label_hidden'];
            }

            $isAllowed = empty($elementConfig['roles']);
            foreach($elementConfig['roles'] as $role) {
                if($this->security->isGranted($role)) {
                    $isAllowed = true;
                    break;
                }
            }

            if(!$isAllowed) {
                continue;
            }

            if(!empty($element['route'])) {
                $elementConfig['path'] = $this->urlGenerator->generate($element['route']);
            }elseif(!empty($element['elements']) && is_array($element['elements'])) {
                $elementConfig['elements'] = $this->parseConfig($element['elements'], $elementConfig['id']);
            }

            $parsedConfig[] = $elementConfig;
        }

        return $parsedConfig;
    }

    private function generateRouteMap($sidebarData): array
    {
        $map = [
            'routes' => [],
            'prefixes' => []
        ];

        foreach ($sidebarData as $element) {
            if (isset($element['route'])) {
                if (!isset($map['routes'][$element['route']])) {
                    $map['routes'][$element['route']] = [$element['id']];
                } else {
                    $map['routes'][$element['route']][] = $element['id'];
                }

                if (strpos($element['route'], '.') !== false) {
                    $prefix = substr($element['route'], 0, strrpos($element['route'], '.'));

                    if (!isset($map['prefixes'][$prefix])) {
                        $map['prefixes'][$prefix] = $element['route'];
                    } else {
                        $map['prefixes'][$prefix] = $element['route'];
                    }
                }
            }

            if (!empty($element['elements'])) {
                $elementsMap = $this->generateRouteMap($element['elements']);
                $map = [
                    'routes' => array_merge($map['routes'], $elementsMap['routes']),
                    'prefixes' => array_merge($map['prefixes'], $elementsMap['prefixes'])
                ];

            }
        }

        return $map;
    }

    private function getCacheFilepath(): string
    {
        return $this->parameters->get('kernel.cache_dir') . '/sidebar.php';
    }
}