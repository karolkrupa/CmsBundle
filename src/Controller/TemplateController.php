<?php

namespace Devster\CmsBundle\Controller;


use Devster\CmsBundle\Crud\Sidebar\Sidebar;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

class TemplateController extends AbstractController
{
    public function __construct(
        private readonly Sidebar $sidebar
    )
    {
    }

    public function sidebar(Request $request, RequestStack $requestStack): Response
    {
        $menuConfig = $this->getConfig();

        return $this->render('@DevsterCms/layout/dashboard/sidebar.html.twig', [
            'config' => $menuConfig['sidebar'],
            'activeTree' => $this->getCurrentRouteData($requestStack)['activeIds'],
        ]);
    }

    public function navbarBreadcrumbs(Request $request, RequestStack $requestStack): Response
    {
        $routeData = $this->getCurrentRouteData($requestStack);

        return $this->render('backend/navbar_breadcrumbs.html.twig', $routeData);
    }

    private function getCurrentRouteData(RequestStack $requestStack)
    {
        $menuConfig = $this->getConfig();

        $currentRoute = $requestStack->getMainRequest()->attributes->get('_route');

        if (!isset($menuConfig['routeMap']['routes'][$currentRoute])) {
            $routePrefix = $currentRoute;
            while (str_contains($routePrefix, '.')) {
                $routePrefix = substr($routePrefix, 0, strrpos($routePrefix, '.'));

                if (isset($menuConfig['routeMap']['prefixes'][$routePrefix])) {
                    $currentRoute = $menuConfig['routeMap']['prefixes'][$routePrefix];
                    break;
                }
            }
        }

        if (!isset($menuConfig['routeMap']['routes'][$currentRoute])) {
            return [
                'activeIds' => [],
                'elements' => []
            ];
        }

        $currentRouteData = [
            'activeIds' => [],
            'elements' => []
        ];

        $currentElements = $menuConfig['sidebar'];
        foreach ($menuConfig['routeMap']['routes'][$currentRoute] as $idIdx => $id) {
            foreach (explode('_', $id) as $idPart) {
                $currentElement = $currentElements[$idPart];

                if ($idIdx == 0) {
                    $currentRouteData['elements'][$currentElement['id']] = $currentElement;
                }
                $currentRouteData['activeIds'][$currentElement['id']] = $currentElement['id'];

                if (!empty($currentElement['elements'])) {
                    $currentElements = $currentElement['elements'];
                }
            }
        }

        $currentRouteData['activeIds'] = array_values($currentRouteData['activeIds']);

        return $currentRouteData;
    }

    private function getConfig()
    {
        return $this->sidebar->getConfig();
    }
}