<?php

namespace Devster\CmsBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class TwigPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        $container->getDefinition('twig')->addMethodCall(
            'addGlobal',
            [
                'devstercms',
                $container->getParameter('devstercms.config')
            ]
        );


    }

}