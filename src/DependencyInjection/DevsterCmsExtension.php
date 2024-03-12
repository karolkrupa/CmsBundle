<?php

namespace Devster\CmsBundle\DependencyInjection;

use Devster\CmsBundle\Crud\Common\TemplatePage\Renderer\PageViewRendererInterface;
use Devster\CmsBundle\Crud\Sidebar\Sidebar;
use Devster\CmsBundle\Form\CKEditorType;
use Devster\CmsBundle\Form\ImageType;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class DevsterCmsExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $container->registerForAutoconfiguration(PageViewRendererInterface::class)
            ->addTag('devster.cms.renderer.page');

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
        $this->processImageTypeConfig($config, $container);

        if(!in_array('Symfony\WebpackEncoreBundle\WebpackEncoreBundle', $container->getParameter('kernel.bundles'))) {
            $config['encore_entry'] = null;
        }

        $container->setParameter('devstercms.config', $config);
    }

    private function processCKEditorConfig(array $config, ContainerBuilder $container): void
    {
        $container->getDefinition(CKEditorType::class)
            ->setArgument('$fileUploadRoute', $config['form']['ckeditor']['file_upload_route']?? null);
    }

    private function processImageTypeConfig(array $config, ContainerBuilder $container): void
    {
        $container->getDefinition(ImageType::class)
            ->setArgument('$route', $config['form']['image']['route']?? null);
    }
}