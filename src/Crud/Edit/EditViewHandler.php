<?php

namespace Devster\CmsBundle\Crud\Edit;

use Devster\CmsBundle\Crud\Common\View\Handler\AbstractPageViewHandler;
use Devster\CmsBundle\Crud\Common\View\PageViewInterface;
use Devster\CmsBundle\Crud\Common\View\PageViewPayloadInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/** @deprecated  */
class EditViewHandler extends AbstractPageViewHandler
{
    public static function getSubscribedServices(): array
    {
        return [
            ...parent::getSubscribedServices(),
            EntityManagerInterface::class,
            UrlGeneratorInterface::class
        ];
    }


    public function handle(PageViewInterface $view, PageViewPayloadInterface $payload): Response
    {
        if (!$view instanceof EditView) {
            throw new \RuntimeException('Niepoprawny typ widoku');
        }

        if (!$payload instanceof EditViewPayload) {
            throw new \RuntimeException('Niepoprawny payload');
        }

        $form = $view->getForm();

        $form->setData($payload->data);

        $form->handleRequest($payload->request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->container->get(EntityManagerInterface::class);

            $em->persist($payload->data);
            $em->flush();

            return new RedirectResponse(
                $this->container->get(UrlGeneratorInterface::class)->generate(
                    $view->getSuccessRoute()
                )
            );
        }

        return new Response(
            $this->getRenderer($view->getRenderer())->render($view, $payload, new EditViewContext($form))
        );
    }
}