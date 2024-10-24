<?php

namespace Devster\CmsBundle\Form\FilePond;

use Symfony\Component\Form\Exception\TransformationFailedException;

class FilePondViewTransformer extends AbstractFilePondViewTransformer
{
    public function __construct(
        protected array $options = ['multiple' => false],
    )
    {
        parent::__construct($options);
    }

    public function transformSingle($value): ?UploadedFileDto
    {
        if ($value && !$value instanceof UploadedFileDto) {
            throw new TransformationFailedException('FilePondType obsługuje jedynie obiekty typu FileDto, przekazano: ' . get_class($value));
        }

        return $value;
    }

    public function reverseTransformSingle($value): ?UploadedFileDto
    {
        if ($value instanceof UploadedFileDto) {
            return $value;
        }

        if (!is_string($value) && !is_numeric($value)) {
            throw new TransformationFailedException('FilePondType obsługuje jedynie typ numeryczny lub string jako dane wejściowe');
        }

        return new UploadedFileDto($value);
    }
}