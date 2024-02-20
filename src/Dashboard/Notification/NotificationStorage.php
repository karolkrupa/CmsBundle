<?php

namespace Devster\CmsBundle\Dashboard\Notification;

use Devster\CmsBundle\Dashboard\Notification\NotificationDto;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class NotificationStorage
{
    const SESSION_KEY = 'devstercms.dashboard.alert.storage';

    public function __construct(private readonly RequestStack $requestStack)
    {
    }

    public function push(NotificationDto $alert): void
    {
        $currentList = $this->getCurrentList();

        if (!isset($currentList[$alert->type])) {
            $currentList[$alert->type] = [];
        }

        $currentList[$alert->type][] = $alert;

        $this->updateCurrentList($currentList);
    }

    public function pop(string $type): ?NotificationDto
    {
        $currentList = $this->getCurrentList();

        if (empty($currentList[$type])) {
            return null;
        }

        $alert = array_pop($currentList[$type]);

        $this->updateCurrentList($currentList);

        return $alert;
    }

    /**
     * @return array<NotificationDto>
     */
    public function popAll(?string $type = null): array
    {
        $currentList = $this->getCurrentList();

        if (!$type) {
            $this->updateCurrentList([]);

            return $currentList;
        }

        if (empty($currentList[$type])) {
            return [];
        }

        $alerts = $currentList[$type];

        unset($currentList[$type]);

        $this->updateCurrentList($currentList);

        return $alerts;
    }

    private function getCurrentList(): array
    {
        if (!$this->getSession()->has(self::SESSION_KEY)) {
            return [];
        }

        return $this->getSession()->get(self::SESSION_KEY);
    }

    private function updateCurrentList(array $list): void
    {
        $this->getSession()->set(self::SESSION_KEY, $list);
    }

    private function getSession(): SessionInterface
    {
        return $this->requestStack->getSession();
    }
}