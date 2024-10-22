<?php

namespace Devster\CmsBundle\Controller;

use Devster\CmsBundle\Dashboard\Notification\NotificationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

trait SortableActionTrait
{
    /**
     * Common sortable action
     * --------------------
     *
     * @param object $entity
     * @param string $message
     * @return RedirectResponse
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    protected function commonSortAction(
        object $entity,
        string $message = 'Kolejność zmieniona',
        string $errorMessage = 'Nie można zmienić kolejności',
        string $returnUrl = null,
        string $errorReturnUrl = null,
        array  $options = [
            'sortParam' => 'sort',
            'prevValue' => 'previous',
            'nextValue' => 'next',
        ]
    ): Response
    {
        $request = $this->container->get(RequestStack::class)->getMainRequest();

        if (!$returnUrl) {
            $returnUrl = $request->headers->get('referer');
        }

        if (!$errorReturnUrl) {
            $errorReturnUrl = $request->headers->get('referer');
        }

        $dir = $request->query->get($options['sortParam']);

        $incrementPosition = $dir == $options['nextValue'];

        if (method_exists($entity, 'setSort')) {
            if($incrementPosition) {
                $entity->setSort($entity->getSort() + 1);
            }else {
                $entity->setSort($entity->getSort() - 1);
            }
        }

        $em = $this->container->get(EntityManagerInterface::class);
        $em->flush();

        $this->container->get(NotificationService::class)->success('Zapisano', $message);

        return new RedirectResponse($returnUrl);
    }
}