<?php

namespace Devster\CmsBundle\Form\FilePond;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\Loader\ChoiceLoaderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class FilePondType extends AbstractType
{
    public function __construct(
        protected EntityManagerInterface   $em,
        protected EventDispatcherInterface $eventDispatcher,
        protected ?string                  $uploadRoute = null
    )
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $modelTransformer = null;
        if ($options['model_transformer_options'] && $options['model_transformer_options']['class']) {
            $builder->addModelTransformer($modelTransformer = new FilePondEntityModelTransformer(
                $this->em,
                $options
            ));
        }

        $builder->addViewTransformer(new FilePondViewTransformer($options, $modelTransformer));
        $builder->addEventSubscriber(new FilePondTypeEventSubscriber($options));
    }

    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        $view->vars['attr'] = [
            ...$view->vars['attr'],
            'multiple' => $options['multiple']
        ];

        $view->vars['route'] = $options['route'];
        $view->vars['multiple'] = $options['multiple'];
        $view->vars['allow_reorder'] = $options['allow_reorder'];
        $view->vars['allow_delete'] = $options['allow_delete'];
        $view->vars['delete_button_show'] = $options['delete_button_show'];
        $view->vars['allow_replace'] = $options['allow_replace'];

        if ($options['multiple']) {
            $view->vars['full_name'] .= '[]';
        }

        $view->vars['max_size'] = str_replace(
            ['M', 'k', 'Mi,', 'Ki'],
            ['MB', 'KB', 'MB', 'KB'],
            $options['max_size'] ?? ini_get('upload_max_filesize')
        );

        $files = [];
        $inputValues = [];

        if (is_array($form->getViewData())) {
            $inputValues = array_map(function ($value) {
                return $value->id;
            }, $form->getViewData());
            $files = $form->getViewData();
        } else if ($form->getViewData()) {
            $inputValues = [$form->getViewData()->id];
            $files = [$form->getViewData()];
        }

        $view->vars['input_value'] = implode(',', $inputValues);

        $filepondFiles = [];

        foreach ($files as $file) {
            $fileData = [
                'source' => $file->id,
                'options' => [
                    'type' => 'local',
                    'file' => [
                        'name' => $file->name,
                        'size' => $file->size,
                        'type' => $file->mimeType,
                    ]
                ]
            ];

            if ($file->previewUrl) {
                $fileData['options']['metadata']['poster'] = $file->previewUrl;
            }

            $filepondFiles[] = $fileData;
        }

        $view->vars['filepond_files'] = $filepondFiles;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        /**
         * Transformacja przesłanego id na obiekt FileDto lub obiekt obsługiwany
         * przez model transformera (model_transformer_options).
         */
        $resolver->setRequired('reverse_file_dto_transformer');
        $resolver->setAllowedTypes('reverse_file_dto_transformer', ['callable']);

        $resolver->setDefaults([
            'data_class' => null, // FileDto[]
            'attr' => [
//                'accept' => 'image/png, image/jpeg, image/gif'
            ],
            'error_bubbling' => false,
            'compound' => false,
            'max_size' => '10M',
            'route' => $this->uploadRoute,

            'model_transformer_options' => [
                'class' => null,
                'id_field' => 'id',
                'size_field' => 'size',
                'mime_field' => 'mimeType',
                'filename_field' => 'filename',
                'preview_url' => null
            ],
            'multiple' => false,
            'allow_delete' => true,
            'allow_replace' => true, // Tylko dla multiple = false
            'delete_button_show' => function (Options $options) {
                if ($options['multiple']) {
                    return $options['allow_delete'];
                }

                // Dla pojedynczych domyślnie pokazujemy przycisk aby dało się podmienić plik
                return $options['allow_replace'] || $options['allow_delete'];
            },
            'allow_reorder' => false,
            'new_file_callback' => null,
            'delete_file_callback' => null
        ]);

        $resolver->setDefault('model_transformer_options', function (OptionsResolver $resolver) {
            $resolver->setDefaults([
                'class' => null,
                'id_field' => 'id',
                'size_field' => 'size',
                'mime_field' => 'mimeType',
                'filename_field' => 'filename',
                'preview_url' => null
            ]);

            $resolver->setAllowedTypes('class', ['null', 'string']);
            $resolver->setAllowedTypes('id_field', ['callable', 'string']);
            $resolver->setAllowedTypes('size_field', ['null', 'callable', 'string']);
            $resolver->setAllowedTypes('mime_field', ['null', 'callable', 'string']);
            $resolver->setAllowedTypes('filename_field', ['null', 'callable', 'string']);
            $resolver->setAllowedTypes('preview_url', ['null', 'callable']);
        });

        $resolver->setAllowedTypes('multiple', 'bool');
        $resolver->setAllowedTypes('allow_delete', 'bool');
        $resolver->setAllowedTypes('delete_button_show', 'bool');
        $resolver->setAllowedTypes('allow_reorder', 'bool');
        $resolver->setAllowedTypes('route', ['string']);
        $resolver->setAllowedTypes('new_file_callback', ['callable', 'null']);
        $resolver->setAllowedTypes('delete_file_callback', ['callable', 'null']);

        if (!$this->uploadRoute) {
            $resolver->setRequired('route');
        }
    }

    public function getBlockPrefix(): string
    {
        return 'file_pond';
    }

    public function getParent(): ?string
    {
        return TextType::class;
    }
}