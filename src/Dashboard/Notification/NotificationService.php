<?php

namespace Devster\CmsBundle\Dashboard\Notification;

use Devster\CmsBundle\Dashboard\Notification\NotificationDto;
use Devster\CmsBundle\Dashboard\Notification\NotificationStorage;

class NotificationService
{
    public function __construct(private readonly NotificationStorage $alertStorage)
    {

    }

    public function info(string $title, string $text, bool $autoClose = true, int $autoCloseDelay = 5000): void
    {
        $this->alertStorage->push(new NotificationDto(
            $title,
            $text,
            'info',
            $autoClose,
            $autoCloseDelay
        ));
    }

    public function success(string $title, string $text, bool $autoClose = true, int $autoCloseDelay = 5000): void
    {
        $this->alertStorage->push(new NotificationDto(
            $title,
            $text,
            'success',
            $autoClose,
            $autoCloseDelay
        ));
    }

    public function error(string $title, string $text, bool $autoClose = false, int $autoCloseDelay = 5000): void
    {
        $this->alertStorage->push(new NotificationDto(
            $title,
            $text,
            'error',
            $autoClose,
            $autoCloseDelay
        ));
    }

    public function warning(string $title, string $text, bool $autoClose = true, int $autoCloseDelay = 5000): void
    {
        $this->alertStorage->push(new NotificationDto(
            $title,
            $text,
            'warning',
            $autoClose,
            $autoCloseDelay
        ));
    }
}