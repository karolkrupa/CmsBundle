<?php

namespace Devster\CmsBundle\Form;

use Devster\CmsBundle\Form\Dto\ImageDto;
use Devster\CmsBundle\Util\ValueExtractor;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\ChoiceList\IdReader;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class ImageType extends AbstractType
{
    public function __construct(
        protected EntityManagerInterface   $em,
        protected EventDispatcherInterface $eventDispatcher,
        protected ?string                  $route = null
    )
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) use ($options) {
            // Konwersja z ID na encje

            $data = $event->getData();
            $targetData = null;

            if (is_array($data)) {
                $targetData = [];

                foreach ($data as $fileId) {
                    $targetData[] = $this->em->getRepository($options['data_class'])->find($fileId);
                }
            } else if ($data) {

                $targetData = $this->em->getRepository($options['data_class'])->find($data);
            }

            $event->setData($targetData);
        });

        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) use ($options) {
            $media = $event->getData();
            if ($media) {
                $event = new ImageSubmittedEvent(
                    $media->getId(),
                    $options['media_handler_options']
                );
                $this->eventDispatcher->dispatch($event, ImageSubmittedEvent::class);
            }
        });
    }

    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        $view->vars['attr'] = [
            ...$view->vars['attr'],
            'multiple' => $options['multiple']
        ];

        $view->vars['route'] = $options['route'];
        $view->vars['multiple'] = $options['multiple'];

        if ($options['multiple']) {
            $view->vars['full_name'] .= '[]';
        }

        $view->vars['max_size'] = str_replace(
            ['M', 'k', 'Mi,', 'Ki'],
            ['MB', 'KB', 'MB', 'KB'],
            $options['max_size'] ?? ini_get('upload_max_filesize')
        );

        $viewValue = null;
        if (is_array($view->vars['value'])) {
            $viewValue = [];
            foreach ($view->vars['value'] as $value) {
                $viewValue[] = $this->convertObjectToDto($value, $options);
            }
        } elseif ($view->vars['value']) {
            $viewValue = $this->convertObjectToDto($view->vars['value'], $options);
        } else {
            $viewValue = [];
        }

        $view->vars['value'] = $viewValue;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'multiple' => false,
            'filesystem_prefix' => null,
            'attr' => [
                'accept' => 'image/png, image/jpeg, image/gif'
            ],
            'error_bubbling' => false,
            'compound' => false,
            'max_size' => '10M',
            'data_class' => null,
            'route' => $this->route,
            'media_handler_options' => [],
            'id_field' => 'id',
            'size_field' => 'size',
            'mime_field' => 'mimeType',
            'filename_field' => 'filename',
        ]);

        $resolver->setAllowedTypes('multiple', 'bool');
        $resolver->setAllowedTypes('route', ['string', 'null']);

        if (!$this->route) {
            $resolver->setRequired('route', 'data_class');
        }
    }

    public function getBlockPrefix(): string
    {
        return 'image';
    }

    public function getParent(): ?string
    {
        return FormType::class;
    }

    private function convertObjectToDto($object, array $options): ?ImageDto
    {
        if (!$object) {
            return null;
        }

        $id = $this->extractValue($object, $options['id_field']);
        if (!$id) {
            throw new \RuntimeException('Nie można przekształcić obiektu do ImageDto');
        }

        $name = $this->extractValue($object, $options['filename_field']);
        $size = $this->extractValue($object, $options['size_field']);
        $mime = $this->extractValue($object, $options['mime_field']);

        return new ImageDto($id, $name, $size?: 0, $mime);

    }

    private function extractValue($data, $getter)
    {
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
}