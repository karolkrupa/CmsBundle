<?php

namespace Devster\CmsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

abstract class AbstractCKEditorTypeController extends AbstractController
{
    /**
     * @param UploadedFile $file - Uploaded file
     * @return array{id: string, url: string}
     */
    abstract protected function upload(UploadedFile $file): array;

    #[Route(name: '.upload')]
    public function uploadAction(Request $request): Response
    {
        $form = $this->createFormBuilder(null, ['csrf_protection' => false])
            ->add('upload', FileType::class)
            ->getForm();

        $form->submit($request->files->all());

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $file */
            $file = $form->get('upload')->getData();

            if (!$file->isValid()) {
                return new Response('Niepoprawny plik', Response::HTTP_BAD_REQUEST);
            }

            $media = $this->upload($file);

            return new JsonResponse([
                'urls' => [
                    'default' => $media['url']
                ],
                'id' => $media['id']
            ]);
        }

        return new JsonResponse([
            'error' => $form->getErrors()->current()->getMessage()
        ], Response::HTTP_BAD_REQUEST);
    }
}