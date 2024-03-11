<?php

namespace Devster\CmsBundle\Controller;

use Devster\CmsBundle\Crud\PageFactory;
use Devster\CmsBundle\Dashboard\Notification\NotificationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AbstractCrudController extends AbstractController
{
    public static function getSubscribedServices(): array
    {
        return [
            ...parent::getSubscribedServices(),
            ...[
                NotificationService::class,
            ]
        ];
    }

    protected function getPageFactory(): PageFactory
    {
        return $this->container->get(PageFactory::class);
    }

    protected function getNotificationService(): NotificationService
    {
        return $this->container->get(NotificationService::class);
    }
}