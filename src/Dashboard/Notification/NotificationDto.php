<?php

namespace Devster\CmsBundle\Dashboard\Notification;

class NotificationDto
{
    public readonly string $id;

    public function __construct(
        public string $title,
        public string $content,
        public string $type,
        public bool   $autoClose = true,
        public int    $autoCloseDelay = 5000
    )
    {
        $this->id = uniqid();
    }
}