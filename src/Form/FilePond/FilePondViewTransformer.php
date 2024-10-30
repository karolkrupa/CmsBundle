<?php

namespace Devster\CmsBundle\Form\FilePond;

use Symfony\Component\Form\Exception\TransformationFailedException;

class FilePondViewTransformer extends AbstractFilePondDataTransformer
{
    public function __construct(
        protected array                           $options = ['multiple' => false],
        protected ?FilePondEntityModelTransformer $modelTransformer = null
    )
    {
        parent::__construct($options);
    }

    public function transformSingle($value): ?FileDto
    {
        if ($value && !$value instanceof FileDto) {
            throw new TransformationFailedException('FilePondType obsługuje jedynie obiekty typu FileDto, przekazano: ' . get_class($value));
        }

        return $value;
    }

    public function reverseTransformSingle($value): ?FileDto
    {
        if ($value instanceof FileDto) {
            return $value;
        }

        if (!is_string($value) && !is_numeric($value)) {
            throw new TransformationFailedException('FilePondType obsługuje jedynie typ numeryczny lub string jako dane wejściowe');
        }

        if (!is_callable($this->options['reverse_file_dto_transformer'])) {
            throw new \LogicException('FilePondType: Brak implementacji transformera id -> FileDto. Sprawdź opcję: reverse_file_dto_transformer');
        }

        $reverseTransformed = $this->options['reverse_file_dto_transformer']($value);

        if (!$this->modelTransformer && !$reverseTransformed instanceof FileDto) {
            throw new \LogicException('FilePondType: Transformer "reverse_file_dto_transformer" musi zwracać wartosć typu FileDto w przypadku braku konfiguracji model transformera');
        }


        if (!$reverseTransformed instanceof FileDto) {
            return $this->modelTransformer->transformSingle($reverseTransformed);
        }

        return $reverseTransformed;
    }
}