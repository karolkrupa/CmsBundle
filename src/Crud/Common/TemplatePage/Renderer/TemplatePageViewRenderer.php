<?php

namespace Devster\CmsBundle\Crud\Common\TemplatePage\Renderer;

use Devster\CmsBundle\Crud\Common\TemplatePage\TemplatePagePayload;
use Devster\CmsBundle\Crud\Common\View\PageViewContextInterface;
use Devster\CmsBundle\Crud\Common\View\PageViewInterface;
use Devster\CmsBundle\Crud\PagePayloadInterface;
use Symfony\Contracts\Service\Attribute\SubscribedService;
use Symfony\Contracts\Service\ServiceSubscriberInterface;
use Symfony\Contracts\Service\ServiceSubscriberTrait;
use Twig\Environment;

class TemplatePageViewRenderer implements PageViewRendererInterface, ServiceSubscriberInterface
{
    use ServiceSubscriberTrait;

    public function render(PageViewInterface $view, PagePayloadInterface $payload, PageViewContextInterface $context): string
    {
        if(!$payload instanceof TemplatePagePayload) {
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