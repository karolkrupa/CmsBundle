<?php

namespace Devster\CmsBundle\Controller;

use Devster\CmsBundle\Form\RemoteChoiceType\ChoiceProviderInterface;
use Devster\CmsBundle\Form\RemoteChoiceType\ChoiceProviderMap;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class RemoteChoiceController extends AbstractController
{
    public static function getSubscribedServices(): array
    {
        return [
            ...parent::getSubscribedServices(),
            EntityManagerInterface::class,
            ChoiceProviderMap::class
        ];
    }

    #[Route(name: '')]
    public function resultsAction(Request $request): JsonResponse
    {
        /** @var ChoiceProviderInterface $provider */
        $provider = $this->container->get(ChoiceProviderMap::class)->get($request->query->get('provider'));

        $choiceList = $provider->getChoices(
            $request->query->getInt('page', 1),
            $request->query->getString('search')
        );

        $results = [];
        foreach ($provider->createView($choiceList->getChoices()) as $choiceView) {
            $results[] = [
                'label' => $choiceView->getLabel(),
                'value' => $choiceView->getValue(),
                'data' => $choiceView->getData()
            ];
        }

        return new JsonResponse([
            'page' => $choiceList->getPageNumber(),
            'total_pages' => $choiceList->getPagesAmount(),
            'data' => $results
        ]);
    }
}