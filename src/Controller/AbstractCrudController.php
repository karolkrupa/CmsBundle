<?php

namespace Devster\CmsBundle\Controller;

use Devster\CmsBundle\Crud\PageFactory;
use Devster\CmsBundle\Dashboard\Notification\NotificationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;

class AbstractCrudController extends AbstractController
{
    public static function getSubscribedServices(): array
    {
        return [
            ...parent::getSubscribedServices(),
            ...[
                NotificationService::class,
                PageFactory::class,
                RequestStack::class,
                EntityManagerInterface::class
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