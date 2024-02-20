<?php

namespace Devster\CmsBundle\DependencyInjection;

use Devster\CmsBundle\Crud\Sidebar\Sidebar;
use Devster\CmsBundle\Form\CKEditorType;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Twig\Environment;

class DevsterCmsExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__ . '/../../config')
        );

        $loader->load('services.yaml');

        $configuration = new Configuration();

        $config = $this->processConfiguration($configuration, $configs);

        $container->getDefinition(Sidebar::class)
            ->setArgument('$sidebarConfigFile',
                sprintf(
                    "%s/%s",
                    $container->getParameter('kernel.project_dir'),
                    $config['sidebar_config_file']
                )
            );


//        $container->registerForAutoconfiguration(ListFieldRendererInterface::class)
//            ->addTag('devster_cms.crud.list.field.renderer');

        $this->processCKEditorConfig($config, $container);

        $container->setParameter('devstercms.dashboard.title', $config['dashboard']['title']?? 'Dashboard');

//        $container->get(Environment::class)->addGlobal('devstercms', [
//            'dashboard' => [
//                'title' => $config['dashboard']['title']?? 'Dashboard'
//            ]
//        ]);
    }



    private function processCKEditorConfig(array $config, ContainerBuilder $container): void
    {
        $container->getDefinition(CKEditorType::class)
            ->setArgument('$fileUploadRoute', $config['ckeditor']['file_upload_route']?? null);
    }
}