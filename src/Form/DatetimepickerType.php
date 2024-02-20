<?php

namespace Devster\CmsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DatetimepickerType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
       $resolver->setDefaults([
           'widget' => 'single_text',
           'html5' => true,
           'required' => false
       ]);
    }


    public function getBlockPrefix(): string
    {
        return 'datetimepicker';
    }

    public function getParent(): ?string
    {
        return DateTimeType::class;
    }
}