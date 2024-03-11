<?php

namespace Devster\CmsBundle\Crud\Edit;

use Devster\CmsBundle\Crud\AbstractPageHandler;
use Devster\CmsBundle\Crud\PageInterface;
use Devster\CmsBundle\Crud\PagePayloadInterface;
use Devster\CmsBundle\Dashboard\Notification\NotificationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class EditPageHandler extends AbstractPageHandler
{
    public static function getSubscribedServices(): array
    {
        return [
            ...parent::getSubscribedServices(),
            EntityManagerInterface::class,
            UrlGeneratorInterface::class,
            NotificationService::class
        ];
    }

    public function handle(PageInterface $page, PagePayloadInterface $payload): Response
    {
        if (!$page instanceof EditPage) {
            throw new \RuntimeException('Niepoprawny typ widoku');
        }

        if (!$payload instanceof EditPagePayload) {
            throw new \RuntimeException('Niepoprawny payload');
        }

        $dispatcher = $page->getPageConfig()->getDispatcher();
        $view = $page->getPageConfig()->getView();
        $data = $payload->data;
        $request = $payload->request;

        $form = $view->getForm();

        $form->setData($data);

        $this->dispatchEvent($dispatcher, EditPageEvents::BEFORE_HANDLE_REQUEST, $data, $form, $page);

        $form->handleRequest($request);

        $this->dispatchEvent($dispatcher, EditPageEvents::AFTER_HANDLE_REQUEST, $data, $form, $page);

        if ($form->isSubmitted()) {

            if ($form->isValid()) {
                $this->dispatchEvent($dispatcher, EditPageEvents::BEFORE_FLUSH, $data, $form, $page);

                $em = $this->container->get(EntityManagerInterface::class);

                $em->persist($data);
                $em->flush();

                $this->dispatchEvent($dispatcher, EditPageEvents::AFTER_FLUSH, $data, $form, $page);

                if($page->getPageConfig()->getSuccessMessage()) {
                    $this->container->get(NotificationService::class)->success('', $page->getPageConfig()->getSuccessMessage());
                }

                if($page->getPageConfig()->getSuccessRoute()) {
                    return new RedirectResponse(
                        $this->container->get(UrlGeneratorInterface::class)->generate(
                            $page->getPageConfig()->getSuccessRoute()
                        )
                    );
                }

                return new RedirectResponse($request->headers->get('referer'));
            } else {
                $this->dispatchEvent($dispatcher, EditPageEvents::VALIDATION_ERROR, $data, $form, $page);
            }
        }

        return new Response(
            $this->getRenderer($view->getRenderer())->render($view, $payload, new EditViewContext($form))
        );
    }

    private function dispatchEvent(EventDispatcherInterface $dispatcher, string $eventName, mixed $data, FormInterface $form, EditPage $page): void
    {
        if ($dispatcher->hasListeners($eventName)) {
            $dispatcher->dispatch(new EditPageEvent($data, $form, $page), $eventName);
        }
    }
}