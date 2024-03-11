<?php

namespace Devster\CmsBundle\Crud\Delete;

use Devster\CmsBundle\Crud\AbstractPageHandler;
use Devster\CmsBundle\Crud\PageInterface;
use Devster\CmsBundle\Crud\PagePayloadInterface;
use Devster\CmsBundle\Dashboard\Notification\NotificationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class DeletePageHandler extends AbstractPageHandler
{
    public static function getSubscribedServices(): array
    {
        return [
            ...parent::getSubscribedServices(),
            EntityManagerInterface::class,
            UrlGeneratorInterface::class,
            NotificationService::class,
            Security::class
        ];
    }

    public function __construct(protected readonly RequestStack $requestStack)
    {
    }

    public function handle(PageInterface $page, PagePayloadInterface $payload): Response
    {
        if (!$page instanceof DeletePage) {
            throw new \RuntimeException('Nieobsługiwany typ stony');
        }

        if (!$payload instanceof DeletePagePayload) {
            throw new \RuntimeException('Nieobsługiwany payload');
        }

        $dispatcher = $page->getPageConfig()->getDispatcher();
        $entity = $payload->getPayload();

        if ($dispatcher->hasListeners(DeletePageEvents::BEFORE_DELETE)) {
            $dispatcher->dispatch(new DeletePageEvent($entity, $page), DeletePageEvents::BEFORE_DELETE);
        }

        $em = $this->container->get(EntityManagerInterface::class);

        if (method_exists($entity, 'setDeletedBy')) {
            $entity->setDeletedBy($this->container->get(Security::class)->getUser());
        }

        if (method_exists($entity, 'delete')) {
            $entity->delete();
        } else if (method_exists($entity, 'setDeletedAt')) {
            $entity->setDeletedAt(new \DateTimeImmutable());
        } else {
            $em->remove($entity);
        }

        if ($dispatcher->hasListeners(DeletePageEvents::AFTER_DELETE)) {
            $dispatcher->dispatch(new DeletePageEvent($entity, $page), DeletePageEvents::AFTER_DELETE);
        }

        $em->flush();

        if ($page->getPageConfig()->getSuccessMessage()) {
            $this->container->get(NotificationService::class)->success('Usunięto', $page->getPageConfig()->getSuccessMessage());
        } else {
            $this->container->get(NotificationService::class)->success('Usunięto', 'Usunięto pomyślnie');
        }

        if($page->getPageConfig()->getSuccessHandler()) {
            return $page->getPageConfig()->getSuccessHandler()->handle(
                $this->container->get(UrlGeneratorInterface::class),
                $page,
                $entity
            );
        }

        return new RedirectResponse(
            $this->requestStack->getMainRequest()->headers->get('referer')
        );
    }
}