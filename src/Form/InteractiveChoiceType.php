<?php

namespace Devster\CmsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\View\ChoiceView;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

class InteractiveChoiceType extends AbstractType
{
    /**
     * @return void
     */
    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        $jsonData = [];

        /** @var ChoiceView $choice */
        foreach ($view->vars['choices'] as $choice) {
            $jsonData[] = [
                'label' => $choice->label,
                'value' => $choice->value
            ];
        }

        $view->vars['json_choices'] = $jsonData;
    }

    public function getBlockPrefix(): string
    {
        return 'interactive_choice';
    }

    public function getParent(): ?string
    {
        return ChoiceType::class;
    }
}