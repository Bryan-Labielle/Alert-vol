<?php

namespace App\Form;

use App\Entity\Annonce;
use App\Entity\Category;
use DateTime;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;

class AnnonceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $start = new DateTime();
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre de votre annonce :',
                'required' => false,
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description du bien :',
                'required' => false,
            ])
            ->add('reference', TextType::class, [
                'label' => 'Immatriculation ou numéro de série :',
                'required' => false,
            ])
            ->add('location', TextType::class, [
                'label' => 'Lieu du vol ou de la perte (code postal) :',
                'required' => false,
            ])
            ->add('details')
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                //'by_reference' => false,
            ])
            ->add('stolenAt', DateType::class, [
                'label' => 'Volé ou perdu le :',
                'data' => $start,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Annonce::class,
        ]);
    }
}
