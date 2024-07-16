<?php

namespace Devster\CmsBundle\Controller;

use App\Event\Backend\Crud\EntityRemovedEvent;
use App\Security\Permission;
use Devster\CmsBundle\Dashboard\Notification\NotificationService;
use Doctrine\ORM\EntityManagerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

trait DeleteActionTrait
{
    /**
     * Common delete action
     * --------------------
     *
     * @param object $entity
     * @param string $message
     * @return JsonResponse
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    protected function commonDeleteAction(
        object $entity,
        string $message = 'Pomyślnie usunięto',
        string $returnUrl = null
    ): Response
    {
        if(!$returnUrl) {
            $returnUrl = $this->container->get(RequestStack::class)->getMainRequest()->headers->get('referer');
        }

        $em = $this->container->get(EntityManagerInterface::class);

        if (method_exists($entity, 'setDeletedBy')) {
            $entity->setDeletedBy($this->getUser());
        }

        if (method_exists($entity, 'delete')) {
            $entity->delete();
        } else if (method_exists($entity, 'setDeletedAt')) {
            $entity->setDeletedAt(new \DateTimeImmutable());
        } else {
            $em->remove($entity);
        }

        $em->flush();

        $this->container->get(NotificationService::class)->success('Usunięto', $message);

        return new RedirectResponse($returnUrl);
    }
}