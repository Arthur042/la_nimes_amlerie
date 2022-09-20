<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Mark;
use App\Entity\Product;
use Doctrine\ORM\EntityRepository;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre du produit',
                'required' => true,
            ])
            ->add('littleDescription', TextType::class, [
                'label' => 'Description courte',
                'required' => true,
            ])
            ->add('fullDescription', CKEditorType::class, [
                'label' => 'Description complète',
                'attr' => [
                    'placeholder' => 'Description complète'
                ]
            ])
            ->add('priceHt', NumberType::class, [
                'label' => 'Prix',
                'attr' => [
                    'placeholder' => 'Prix',
                    'min' => 0
                ],
            ])
            ->add('tva', NumberType::class, [
                'label' => 'TVA',
                'attr' => [
                    'placeholder' => 'TVA',
                    'min' => 0
                ],
            ])
            ->add('quantity', NumberType::class, [
                'label' => 'quantité',
                'attr' => [
                    'placeholder' => 'quantité',
                    'min' => 0
                ],
            ])
            ->add('isAvailable', ChoiceType::class, [
                'label' => 'disponibilité',
                'required' =>  true,
                'choices'  => [
                    'en Stock' => true,
                    'Hors Stock' => false,
                ],
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.name', 'ASC')
                        ->where('c.parentCategory is not null')
                        ;
                }
            ])
            ->add('mark', EntityType::class, [
                'class' => Mark::class,
                'choice_label' => 'name',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('m')
                        ->orderBy('m.name', 'ASC')
                        ;
                }
            ])
            ->add('thumbnail', FileType::class, [
                'label' => 'photo',
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
            'data_class' => Product::class,
        ]);
    }
}
