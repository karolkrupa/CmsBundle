<?php

namespace Devster\CmsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MonthType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->addViewTransformer(new CallbackTransformer(
            function ($val) {

                if($val instanceof \DateTimeInterface) {
                    return $val->format('Y-m');
                }

                return '';
            },
            function ($val) {
                $dateTime = \DateTime::createFromFormat('Y-m', $val);

                if(!$dateTime) {
                    return null;
                }

                $dateTime->modify('first day of this month');
                $dateTime->setTime(0, 0, 0);

                return $dateTime;
            }
        ));
    }

    public function finishView(FormView $view, FormInterface $form, array $options): void
    {
        $view->vars['min_date'] = $options['min_date'];
        $view->vars['max_date'] = $options['max_date'];
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'min_date' => date('Y-01'),
            'max_date' => date('Y-12'),
            'data_class' => null
        ]);
    }


    public function getBlockPrefix(): string
    {
        return 'month';
    }

    public function getParent(): ?string
    {
        return TextType::class;
    }
}