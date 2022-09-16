<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('oldPassword', \Symfony\Component\Form\Extension\Core\Type\PasswordType::class, [
                'attr' => [
                    'placeholder' => 'Ancien mot de passe'
                ]
            ])
            ->add('newPassword', \Symfony\Component\Form\Extension\Core\Type\PasswordType::class, [
                'attr' => [
                    'placeholder' => 'Nouveau mot de passe'
                ]
            ])
            ->add('confirmPassword', \Symfony\Component\Form\Extension\Core\Type\PasswordType::class, [
                'attr' => [
                    'placeholder' => 'Confirmer le nouveau mot de passe'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
