<?php

namespace Devster\CmsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\HeaderUtils;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Constraints\NotBlank;

abstract class AbstractImageTypeController extends AbstractController
{
    /**
     * @param UploadedFile $file - Uploaded file
     * @return string - File ID
     */
    abstract protected function upload(UploadedFile $file): string;

    /**
     * @param string $id - File ID
     * @return array{path: ?string, path: ?string, filename: string, contentType: ?string} - resolve order: path, content
     */
    abstract protected function fetch(string $id): array;

    #[Route(name: '.upload')]
    public function uploadAction(Request $request): Response
    {
        $form = $this->createFormBuilder(null, [
            'csrf_protection' => false
        ])
            ->add('file', FileType::class, [
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->getForm();

        $form->submit([
            'file' => $request->files->get('file')
        ]);

        if (!$form->isValid()) {
            throw new \RuntimeException($form->getErrors()->current()->getMessage());
        }

        $fileId = $this->upload($form->get('file')->getData());

        return new Response($fileId);
    }

    #[Route('/{id}', name: '.fetch')]
    public function fetchAction(string $id): Response
    {
        $fileData = $this->fetch($id);

        if (empty($fileData['path']) && empty($fileData['content'])) {
            throw new \RuntimeException('Wymagany klucz "path" lub "content"');
        }

        if (!empty($fileData['path'])) {
            $response = new BinaryFileResponse($fileData['path']);
        } else {
            $response = new Response($fileData['content']);
        }

        $disposition = HeaderUtils::makeDisposition(
            HeaderUtils::DISPOSITION_ATTACHMENT,
            $fileData['filename'] ?: 'Brak nazwy'
        );

        $response->headers->set('Content-Disposition', $disposition);

        if (!empty($fileData['contentType'])) {
            $response->headers->set('Content-Type', $fileData['contentType']);
        }

        return $response;
    }
}