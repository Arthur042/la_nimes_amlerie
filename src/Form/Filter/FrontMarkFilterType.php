<?php

namespace App\Form\Filter;

use App\Entity\Category;
use Doctrine\ORM\EntityRepository;
use Lexik\Bundle\FormFilterBundle\Filter\FilterOperands;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type\EntityFilterType;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type\NumberRangeFilterType;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type\TextFilterType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class FrontMarkFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextFilterType::class, [
                'condition_pattern' => FilterOperands::STRING_CONTAINS,
                'label' => 'Chercher une référence'
            ])
            ->add('priceHt', NumberRangeFilterType::class, [
                'label' => 'Prix compris entre',
                'attr' =>  [
                    'class' => 'filterRangeInput'
                ]
            ])
            ->add('category', EntityFilterType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.name', 'ASC')
                        ->where('c.parentCategory is not null')
                        ;
                },
                'label' => 'Catégorie',
                'placeholder' => 'Sélectionner'
            ])
        ;
    }
}
