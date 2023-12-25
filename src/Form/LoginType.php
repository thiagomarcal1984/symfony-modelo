<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class LoginType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('_username', options: [
                'label' => 'Usuário',
                'constraints' => new NotBlank([
                    'message' => 'O nome de usuário é um campo obrigatório.'
                ]),
            ])
            ->add('_password', PasswordType::class,[
                'label' => 'Senha',
                'constraints' => new NotBlank([
                    'message' => 'Senha é um campo obrigatório.'
                ]),
            ])
        ;
    }

    public function getBlockPrefix() : string
    {
        return '';
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
            'attr' => [
                'novalidate' => 'novalidate',
            ]
        ]);
    }
}
