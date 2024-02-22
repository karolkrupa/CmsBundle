<?php

namespace Devster\CmsBundle;

use Devster\CmsBundle\Crud\Common\Renderer\PageViewRendererInterface;
use Devster\CmsBundle\Crud\Common\View\PageViewHandlerInterface;
use Devster\CmsBundle\Crud\List\Action\Renderer\ActionRenderInterface;
use Devster\CmsBundle\Crud\List\Cell\Renderer\CellRendererInterface;
use Devster\CmsBundle\Crud\List\Heading\Renderer\HeadingRendererInterface;
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

        $container->registerForAutoconfiguration(ActionRenderInterface::class)
            ->addTag('devster.cms.renderer.action');

        $container->registerForAutoconfiguration(CellRendererInterface::class)
            ->addTag('devster.cms.renderer.cell');

        $container->registerForAutoconfiguration(HeadingRendererInterface::class)
            ->addTag('devster.cms.renderer.heading');



        $container->registerForAutoconfiguration(PageViewHandlerInterface::class)
            ->addTag('devster.cms.view.handler');


//        $container->register('devster_cms.crud.list.field.renderer_locator', ServiceLocator::class)
//            ->setArguments(new Reference())


    }



    public function getContainerExtension(): ?ExtensionInterface
    {
        return new DevsterCmsExtension();
    }
}