<?php

namespace Devster\CmsBundle\Form\FilePond;

use Doctrine\Common\Util\ClassUtils;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class FilePondEntityModelTransformer extends AbstractFilePondViewTransformer
{
    private array $transformerOptions = [
        'class' => null,
        'id_field' => 'id',
        'size_field' => 'size',
        'mime_field' => 'mimeType',
        'filename_field' => 'filename',
        'preview_url' => null
    ];

    public function __construct(
        protected readonly EntityManagerInterface $em,
        protected array                           $options = ['multiple' => false],
    )
    {
        parent::__construct($options);

        $this->transformerOptions = array_merge(
            $this->transformerOptions,
            $options['model_transformer_options'] ?: []
        );
    }

    public function transformSingle($value): ?UploadedFileDto
    {
        if ($value && !$value instanceof $this->transformerOptions['class']) {
            throw new TransformationFailedException(sprintf(
                'FilePondType obsługuje jedynie obiekty typu %s, przekazano: %s',
                $this->transformerOptions['class'],
                get_class($value)
            ));
        }

        return $this->transformEntity($value);
    }

    public function reverseTransformSingle($value): mixed
    {
        if (!$value instanceof UploadedFileDto) {
            throw new TransformationFailedException('FilePondType obsługuje jedynie typ UploadedFileDto jako dane wejściowe');
        }

        return $this->reverseTransformEntity($value);
    }

    private function transformEntity(mixed $value): ?FileDto
    {
        if (!$value) return null;

        if (!$value instanceof $this->transformerOptions['class']) {
            throw new TransformationFailedException(sprintf(
                "Przekazany typ obiektu (%s) jest niezgody z ustawionym %s",
                ClassUtils::getClass($value),
                $this->options['class']
            ));
        }

        return new FileDto(
            $this->extractValue($value, $this->transformerOptions['id_field']),
            $this->extractValue($value, $this->transformerOptions['filename_field']),
            $this->extractValue($value, $this->transformerOptions['size_field']),
            $this->extractValue($value, $this->transformerOptions['mime_field']),
            $this->transformerOptions['preview_url'] ? $this->transformerOptions['preview_url']($value) : null
        );
    }

    private function extractValue(mixed $data, null|string|\Closure $getter): mixed
    {
        if (!$getter) {
            return null;
        }

        if ($getter instanceof \Closure) {
            return $getter($data);
        }

        if (is_array($data)) {
            if (!isset($data[$getter])) {
                return null;
            }

            return $data[$getter];
        }

        $getterName = ucfirst($getter);
        $getters = [
            "get{$getterName}",
            "is{$getterName}"
        ];

        foreach ($getters as $possibleGetter) {
            if (method_exists($data, $possibleGetter)) {
                return $data->$possibleGetter();
            }
        }

        return null;
    }

    private function reverseTransformEntity(UploadedFileDto $value): mixed
    {
        $repository = $this->em->getRepository($this->transformerOptions['class']);

        if (!$repository) {
            throw new TransformationFailedException(sprintf(
                "Repozytorium dla klasy %s nie istnieje",
                $this->transformerOptions['class']
            ));
        }

        return $repository->find($value->id);
    }
}