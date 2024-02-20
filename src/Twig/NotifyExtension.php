<?php

namespace Devster\CmsBundle\Twig;

use Devster\CmsBundle\Dashboard\Notification\NotificationStorage;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class NotifyExtension extends AbstractExtension
{
    public function __construct(private readonly NotificationStorage $alertStorage)
    {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('get_dashboard_notifications', [$this, 'getNotifications']),
        ];
    }

    public function getNotifications(?string $type = null): array
    {
        return $this->alertStorage->popAll($type);
    }

}