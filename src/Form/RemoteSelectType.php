<?php

namespace Devster\CmsBundle\Form;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\View\ChoiceView;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RemoteSelectType extends AbstractType
{
    public function __construct(
        private readonly EntityManagerInterface $em
    )
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) use ($options) {
            $entityId = $event->getData();

            if ($entityId) {
                $entity = $this->em->getRepository($options['class'])->find($entityId);

                $event->setData($entity);
            }
        });
    }

    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        $selectedValue = $form->getData();

        if ($selectedValue) {
            $labelTransformer = $options['choice_label'];
            if (is_callable($labelTransformer)) {
                $currentLabel = $labelTransformer($selectedValue);
            } elseif (is_string($labelTransformer)) {
                $getter = 'get' . ucfirst($labelTransformer);
                $currentLabel = $selectedValue->$getter();
            }else {
                $currentLabel = (string)$selectedValue;
            }

            $valueTransformer = $options['choice_value']?: 'id';
            if (is_callable($valueTransformer)) {
                $currentValue = (string)$valueTransformer($selectedValue);
            } elseif (is_string($valueTransformer)) {
                $getter = 'get' . ucfirst($valueTransformer);
                $currentValue = $selectedValue->$getter();
            }else {
                $currentValue = (string)$selectedValue;
            }

            $choices = [
                new ChoiceView(
                    $selectedValue,
                    $currentValue,
                    $currentLabel
                )
            ];
        } else {
            $choices = [];
        }


        $view->vars['expanded'] = false;
        $view->vars['multiple'] = false;
        $view->vars['preferred_choices'] = [];
        $view->vars['placeholder'] = $options['placeholder'];
        $view->vars['choice_translation_domain'] = false;
        $view->vars['value'] = $selectedValue ? $selectedValue->getId() : null;
        $view->vars['choices'] = $choices;
    }


    public function finishView(FormView $view, FormInterface $form, array $options): void
    {
        parent::buildView($view, $form, $options);

        $view->vars['route'] = $options['route'];

        $view->vars['required'] = false;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'compound' => false,
            'choice_label' => false,
            'choice_value' => false,
            'choices' => [],
            'placeholder' => 'Brak...',
            'expanded' => false
        ]);

        $resolver->setRequired([
            'route',
            'class'
        ]);
    }


    public function getBlockPrefix(): string
    {
        return 'remote_select';
    }

    public function getParent(): ?string
    {
        return FormType::class;
    }
}