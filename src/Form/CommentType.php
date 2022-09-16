<?php

namespace App\Form;

use App\Entity\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description', TextareaType::class, [
                'label' => false,
                'required' => false,
                'attr' => array(
                    'placeholder' => 'écrire le commentaire'
                )
            ])
            ->add('note', ChoiceType::class, [
                'choices' => [
                    '★' => '1',
                    ' ★' => '2',
                    '★ ' => '3',
                    '  ★' => '4',
                    '★  ' => '5',
                ],
                'expanded' => true,
                'attr' => [
                    'class' => 'myNote'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}
