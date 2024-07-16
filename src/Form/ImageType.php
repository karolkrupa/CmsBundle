<?php

namespace Devster\CmsBundle\Form;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\ChoiceList\IdReader;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
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
            if($media = $event->getData()) {
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


        if (is_array($view->vars['value'])) {
            $viewValue = [];
            foreach ($view->vars['value'] as $value) {
                $viewValue[] = $value->getId();
            }
        } elseif ($view->vars['value']) {
            $view->vars['value'] = $view->vars['value']->getId();
        }else {
            $view->vars['value'] = [];
        }
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
            'media_handler_options' => []
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
}