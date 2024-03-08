<?php

namespace Devster\CmsBundle\Crud\Edit;

use Devster\CmsBundle\Crud\AbstractPageHandler;
use Devster\CmsBundle\Crud\PageInterface;
use Devster\CmsBundle\Crud\PagePayloadInterface;
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
            UrlGeneratorInterface::class
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

        $form = $view->getForm();

        $form->setData($data);

        $this->dispatchEvent($dispatcher, EditPageEvents::BEFORE_HANDLE_REQUEST, $data, $form);

        $form->handleRequest($payload->request);

        $this->dispatchEvent($dispatcher, EditPageEvents::AFTER_HANDLE_REQUEST, $data, $form);

        if ($form->isSubmitted()) {

            if ($form->isValid()) {
                $this->dispatchEvent($dispatcher, EditPageEvents::BEFORE_FLUSH, $data, $form);

                $em = $this->container->get(EntityManagerInterface::class);

                $em->persist($data);
                $em->flush();

                $this->dispatchEvent($dispatcher, EditPageEvents::AFTER_FLUSH, $data, $form);

                return new RedirectResponse(
                    $this->container->get(UrlGeneratorInterface::class)->generate(
                        $page->getPageConfig()->getSuccessRoute()
                    )
                );
            } else {
                $this->dispatchEvent($dispatcher, EditPageEvents::VALIDATION_ERROR, $data, $form);
            }
        }

        return new Response(
            $this->getRenderer($view->getRenderer())->render($view, $payload, new EditViewContext($form))
        );
    }

    private function dispatchEvent(EventDispatcherInterface $dispatcher, string $eventName, mixed $data, FormInterface $form): void
    {
        if ($dispatcher->hasListeners($eventName)) {
            $dispatcher->dispatch(new EditPageEvent($data, $form), $eventName);
        }
    }
}