<?php

namespace Devster\CmsBundle\Form\RemoteChoiceType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RemoteChoiceType extends AbstractType
{
    public function __construct(
        private readonly ChoiceProviderMap $choiceProviderMap,
        private ?string                    $route = null // devster_cms.form.remote_choice.route
    )
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $this->route = $options['route'];

        /** @var ChoiceProviderInterface $choiceProvider */
        $choiceProvider = $this->choiceProviderMap->get($options['choice_provider']);

        $builder->setAttribute('choice_provider', $choiceProvider);

        $builder->addViewTransformer(new CallbackTransformer(
            function ($value) use ($choiceProvider) {
                if (!$value) {
                    return null;
                }

                return current($choiceProvider->createView([$value]));
            },
            function ($value) use ($choiceProvider) {
                if (!$value) {
                    return null;
                }

                return current($choiceProvider->getChoicesForValues([$value]));
            }
        ));
    }

    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        /** @var ChoiceProviderInterface $choiceProvider */
        $choiceProvider = $form->getConfig()->getAttribute('choice_provider');

        $choiceList = $choiceProvider->getChoices(1);

        $view->vars['route'] = $options['route'];
        $view->vars['provider_name'] = $options['choice_provider'];
        $view->vars['expanded'] = false;
        $view->vars['multiple'] = false;
        $view->vars['preferred_choices'] = [];
        $view->vars['placeholder'] = $options['placeholder'];
        $view->vars['choice_translation_domain'] = false;
        $view->vars['choices'] = $choiceProvider->createView($choiceList->getChoices());
        $view->vars['pagination'] = [
            'page' => $choiceList->getPageNumber() ?: 1,
            'totalPages' => $choiceList->getPagesAmount() ?: 1
        ];
    }


    public function finishView(FormView $view, FormInterface $form, array $options): void
    {
        parent::buildView($view, $form, $options);

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
            'choice_provider',
            'route'
        ]);

        $resolver->setInfo('choice_provider', 'Nawa providera dla opcji. Nazwa brana z Devster\CmsBundle\Form\RemoteChoiceType\ChoiceProviderInterface::getKey');
        $resolver->setInfo('route', 'Routing dla endpointa pobierania danych. Devster\CmsBundle\Controller\RemoteChoiceController::resultsAction');

        $resolver->setAllowedTypes('choice_provider', ['string']);
        $resolver->setAllowedTypes('route', ['string']);

        if ($this->route) {
            $resolver->setDefault('route', $this->route);
        }
    }


    public function getBlockPrefix(): string
    {
        return 'remote_choice';
    }

    public function getParent(): ?string
    {
        return FormType::class;
    }
}