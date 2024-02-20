<?php

namespace Devster\CmsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class StrongPasswordType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'attr' => [
                'autocomplete' => 'new-password'
            ],
            'constraints' => [
                new Length(null, 6),
                new Callback(function ($value, ExecutionContextInterface $context) {
                    if(!$value) return;

                    if(strlen($value) >= 6) {
                        return;
                    }

                    $context->buildViolation('Hasło musi zawierać conajmniej 6 znaków')
                        ->addViolation();
                }),
                new Callback(function ($value, ExecutionContextInterface $context) {
                    if(!$value) return;

                    for ($i = 0; $i < strlen($value); $i++) {
                        if (ctype_lower($value[$i])) {
                            return;
                        }
                    }

                    $context->buildViolation('Hasło musi zawierać małą literę')
                        ->addViolation();
                }),
                new Callback(function ($value, ExecutionContextInterface $context) {
                    if(!$value) return;

                    for ($i = 0; $i < strlen($value); $i++) {
                        if (ctype_upper($value[$i])) {
                            return;
                        }
                    }

                    $context->buildViolation('Hasło musi zawierać wielką literę')
                        ->addViolation();
                }),
                new Callback(function ($value, ExecutionContextInterface $context) {
                    if(!$value) return;

                    if (preg_match('/[\d]/', $value)) {
                        return;
                    }

                    $context->buildViolation('Hasło musi zawierać cyfrę')
                        ->addViolation();
                }),
                new Callback(function ($value, ExecutionContextInterface $context) {
                    if(!$value) return;

                    if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $value)) {
                        return;
                    }

                    $context->buildViolation('Hasło musi zawierać znak specjalny')
                        ->addViolation();
                })
            ]
        ]);
    }


    public function getBlockPrefix(): string
    {
        return 'strong_password';
    }

    public function getParent(): ?string
    {
        return PasswordType::class;
    }
}