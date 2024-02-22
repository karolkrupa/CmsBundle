<?php

namespace Devster\CmsBundle\Crud\Common\View;

use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\DependencyInjection\ServiceLocator;
use Symfony\Contracts\Service\Attribute\SubscribedService;
use Symfony\Contracts\Service\ServiceSubscriberInterface;
use Symfony\Contracts\Service\ServiceSubscriberTrait;

abstract class AbstractPageViewHandler implements PageViewHandlerInterface, ServiceSubscriberInterface
{
    use ServiceSubscriberTrait;

    public static function getSubscribedServices(): array
    {
        return [
            new SubscribedService('renderers', ServiceLocator::class, attributes: new Autowire(service: 'devster.cms.renderer.page.locator'))
        ];
    }

    /**
     * @template T
     * @param class-string<T> $class
     * @return T
     */
    protected function getRenderer(string $class)
    {
        return $this->container->get('renderers')->get($class);
    }
}