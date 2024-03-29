<?php

namespace Devster\CmsBundle\Crud\Common\View\Handler;

use Devster\CmsBundle\Crud\Common\TemplatePage\Renderer\PageViewRendererInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\DependencyInjection\ServiceLocator;
use Symfony\Contracts\Service\Attribute\SubscribedService;
use Symfony\Contracts\Service\ServiceSubscriberInterface;
use Symfony\Contracts\Service\ServiceSubscriberTrait;

/** @deprecated  */
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
     * Returns page renderer by class FQN
     *
     * @template C
     * @param class-string<C> $class
     * @return C
     */
    protected function getRenderer(string $class): PageViewRendererInterface
    {
        return $this->container->get('renderers')->get($class);
    }
}