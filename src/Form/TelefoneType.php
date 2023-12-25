<?php

namespace App\Form;

use App\Entity\Aluno;
use App\Entity\Telefone;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class TelefoneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('numero', options: [
                'constraints' => [
                    new Regex('/\d{2}\s*\d{4,5}[\s-]*\d{4}/', 'Telefone com formato inválido.')
                ],
            ])
            ->add('aluno', EntityType::class, [
                'class' => Aluno::class,
                'choice_label' => 'nome',
                'placeholder' => 'Escolha um aluno',
                'constraints' => [
                    new NotBlank(message: 'Escolha um aluno.'),
                ],
                'required' => false, // Desligamos o required para fazer a validação server-side.
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Telefone::class,
        ]);
    }
}
