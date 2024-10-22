<?php

namespace Devster\CmsBundle\Controller;

use Devster\CmsBundle\Dashboard\Notification\NotificationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

trait RestoreActionTrait
{
    /**
     * Common restore action
     * --------------------
     *
     * @param object $entity
     * @param string $message
     * @return RedirectResponse
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    protected function commonRestoreAction(
        object $entity,
        string $message = 'Pomyślnie przywrócono',
        string $errorMessage = 'Nie można przywrócić',
        string $returnUrl = null,
        string $errorReturnUrl = null,
    ): Response
    {
        if(!$returnUrl) {
            $returnUrl = $this->container->get(RequestStack::class)->getMainRequest()->headers->get('referer');
        }

        if(!$errorReturnUrl) {
            $errorReturnUrl = $this->container->get(RequestStack::class)->getMainRequest()->headers->get('referer');
        }

        if (method_exists($entity, 'getDeletedAt')) {
            if (!$entity->getDeletedAt()) {
                $this->container->get(NotificationService::class)->error('Błąd', $errorMessage);

                return new RedirectResponse($errorReturnUrl);
            }
        }

        $em = $this->container->get(EntityManagerInterface::class);

        if (method_exists($entity, 'setRestoredBy')) {
            $entity->setRestoredBy($this->getUser());
        }

        if (method_exists($entity, 'setDeletedAt')) {
            $entity->setDeletedAt(null);
        }

        $em->flush();

        $this->container->get(NotificationService::class)->success('Przywrócono', $message);

        return new RedirectResponse($returnUrl);
    }
}