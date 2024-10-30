<?php

namespace Devster\CmsBundle\Form\FilePond;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

abstract class AbstractFilePondDataTransformer implements DataTransformerInterface
{
    public function __construct(protected array $options = ['multiple' => false])
    {
    }

    abstract public function transformSingle($value): mixed;

    abstract public function reverseTransformSingle($value): mixed;

    public function transform(mixed $value)
    {
        if ($this->options['multiple']) {
            if (!$value) {
                return [];
            }

            if (!is_iterable($value)) {
                return [$this->transformSingle($value)];
            }

            $transformed = [];
            foreach ($value as $item) {
                $transformed[] = $this->transformSingle($item);
            }

            return $transformed;
        } else {
            if (is_array($value)) {
                throw new TransformationFailedException('Typy iterowalne obsługiwane są jedynie z opcją multiple');
            }
        }

        return $this->transformSingle($value);
    }

    public function reverseTransform(mixed $value)
    {
        if ($this->options['multiple']) {
            if (!$value) {
                return [];
            }

            if (!is_iterable($value)) {
                return [$this->reverseTransformSingle($value)];
            }

            return array_map(function ($id) {
                return $this->reverseTransformSingle($id);
            }, $value);
        } else {
            if (is_iterable($value)) {
                throw new TransformationFailedException('Typy iterowalne obsługiwane są jedynie z opcją multiple');
            }
            if ($value) {
                return $this->reverseTransformSingle($value);
            }

            return null;
        }
    }
}