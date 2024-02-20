<?php

namespace Devster\CmsBundle\Controller;

use Devster\CmsBundle\Form\Dto\RemoteSelectOptionDto;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

abstract class AbstractRemoteSelectTypeController extends AbstractController
{
    /**
     * @param string|null $search
     * @return array<RemoteSelectOptionDto>
     */
    abstract protected function getData(?string $search = null): array;

    #[Route(name: '')]
    public function resultsAction(Request $request): JsonResponse
    {
        return $this->response($this->getData(
            $request->query->get('s')
        ));
    }

    /**
     * @param array<RemoteSelectOptionDto> $data
     * @return JsonResponse
     */
    protected function response(array $data): JsonResponse
    {
        return new JsonResponse($data);
    }

    protected function createOption(string $label, string $value, string $id): RemoteSelectOptionDto
    {
        return new RemoteSelectOptionDto(
            $label,
            $value,
            $id
        );
    }
}