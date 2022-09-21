<?php

namespace App\Form;

use App\Entity\Mark;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class MarkType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom de la marque',
                'required' => true,
            ])
            ->add('pathImage', FileType::class, [
                'label' => 'logo de la marque',
                'mapped' => false,
                'constraints' => [
                    new File(
                        maxSize: '2048k',
                        mimeTypes: ['image/png', 'image/jpeg'],
                        mimeTypesMessage: 'Ce format d\'image n\'est pas pris en compte',
                    )
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Mark::class,
        ]);
    }
}
