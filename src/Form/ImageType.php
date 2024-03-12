<?php

namespace Devster\CmsBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ImageType extends AbstractType
{
    public function __construct(
        protected ?string $route = null
    )
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) use ($options) {
            $data = $event->getData();
            $targetData = null;

            if (is_array($data)) {
                $targetData = array_column($data, 0);
            } else if ($data) {
                $targetData = $data;
            }

            $event->setData($targetData);
        }, 99999);
    }

    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        $view->vars['attr'] = [
            ...$view->vars['attr'],
            'multiple' => $options['multiple']
        ];

        $view->vars['route'] = $options['route'];

        if ($options['multiple']) {
            $view->vars['full_name'] .= '[]';
        }

        $view->vars['max_size'] = str_replace(
            ['M', 'k', 'Mi,', 'Ki'],
            ['MB', 'KB', 'MB', 'KB'],
            $options['max_size'] ?? ini_get('upload_max_filesize')
        );
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
            'route' => $this->route
        ]);

        $resolver->setAllowedTypes('multiple', 'bool');
        $resolver->setAllowedTypes('route', ['strong', 'null']);

        if(!$this->route) {
            $resolver->setRequired('route');
        }
    }

    public function getBlockPrefix(): string
    {
        return 'image';
    }

    public function getParent(): string
    {
        return EntityType::class;
    }
}