<?php

namespace Devster\CmsBundle;

use Devster\CmsBundle\Crud\List\Cell\ListFieldRendererInterface;
use Devster\CmsBundle\DependencyInjection\CrudPass;
use Devster\CmsBundle\DependencyInjection\DevsterCmsExtension;
use Devster\CmsBundle\DependencyInjection\TwigPass;
use Symfony\Component\DependencyInjection\Compiler\ServiceLocatorTagPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ServiceLocator;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

class DevsterCmsBundle extends AbstractBundle
{
    public function build(ContainerBuilder $container)
    {


        $container->addCompilerPass(new CrudPass());
        $container->addCompilerPass(new TwigPass());


//        $container->register('devster_cms.crud.list.field.renderer_locator', ServiceLocator::class)
//            ->setArguments(new Reference())


    }



    public function getContainerExtension(): ?ExtensionInterface
    {
        return new DevsterCmsExtension();
    }
}