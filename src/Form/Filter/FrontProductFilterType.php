<?php

namespace App\Form\Filter;

use App\Entity\Category;
use App\Entity\Mark;
use Doctrine\ORM\EntityRepository;
use Lexik\Bundle\FormFilterBundle\Filter\FilterOperands;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type\EntityFilterType;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type\NumberFilterType;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type\NumberRangeFilterType;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type\TextFilterType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FrontProductFilterType extends AbstractType
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
            ->add('mark', EntityFilterType::class, [
                'class' => Mark::class,
                'choice_label' => 'name',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('m')
                        ->orderBy('m.name', 'ASC')
                        ;
                },
                'label' => 'Marque',
                'placeholder' => 'Sélectionner'
            ])
        ;
    }
}
