<?php

namespace App\Form;

use App\Entity\Category;
use App\Service\SearchData;
use DateTime;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('categories', EntityType::class, [
            'label' => false,
            'required' => false,
            'class' => Category::class,
            'choice_label' => 'name',
            'expanded' => true,
            'multiple' => true,
        ])
        ->add('placeSearch', TextType::class, [
            'label' => 'Filtrer par ville',
            'required' => false,
            'attr' => [
                'placeholder' => 'Ville',
                'class' => 'form-control rounded-pill']
        ])
            ->add('dateSearch', DateType::class, [
                'label' => 'Filtrer par date depuis le',
                'required' => false,
            ])
            ->add('search', TextType::class, [
                'label' => 'Recherche avancée',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Mots clés',
                    'class' => 'form-control rounded-pill'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SearchData::class,
            'method' => 'GET',
            'csrf_protection' => false,
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
