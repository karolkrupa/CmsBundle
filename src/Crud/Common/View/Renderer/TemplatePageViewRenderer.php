<?php

namespace Devster\CmsBundle\Crud\Common\View\Renderer;

use Devster\CmsBundle\Crud\Common\View\Renderer\PageViewRendererInterface;
use Devster\CmsBundle\Crud\Common\View\TemplatePageViewPayload;
use Devster\CmsBundle\Crud\Common\View\PageViewContextInterface;
use Devster\CmsBundle\Crud\Common\View\PageViewInterface;
use Devster\CmsBundle\Crud\Common\View\PageViewPayloadInterface;
use Symfony\Contracts\Service\Attribute\SubscribedService;
use Symfony\Contracts\Service\ServiceSubscriberInterface;
use Symfony\Contracts\Service\ServiceSubscriberTrait;
use Twig\Environment;

class TemplatePageViewRenderer implements PageViewRendererInterface, ServiceSubscriberInterface
{
    use ServiceSubscriberTrait;

    public function render(PageViewInterface $view, PageViewPayloadInterface $payload, PageViewContextInterface $context): string
    {
        if(!$payload instanceof TemplatePageViewPayload) {
            throw new \RuntimeException('Niepoprawy typ payloudu');
        }

        if(!$view->getTemplate()) {
            throw new \RuntimeException('TemplatePageView musi mieć ustawiony szablon');
        }

        return $this->twig()->render('@DevsterCms/crud/common/view/page.html.twig', [
            'html' => $this->twig()->render(
                $view->getTemplate(),
                $payload->getPayload()
            )
        ]);
    }

    #[SubscribedService]
    protected function twig(): Environment
    {
        return $this->container->get(__METHOD__);
    }
}