<?php

namespace App\Form;

use App\Entity\Annonce;
use App\Entity\Category;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;

class AnnonceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'required' => true])
            /*->add('annonceImages', FileType::class, array(
                'label' => 'Photos (jpg, jpeg, png, pdf files)',
                'mapped' => true,
                'required' => true,
                /*'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'application/jpg',
                            'application/jpeg',
                            'application/png',
                            'application/pdf',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid document',])
                ]),
            )*/
            ->add('owner', HiddenType::class)
            ->add('description', TextareaType::class)
            ->add('publishedAt', DateType::class)
            ->add('endPublishedAt', HiddenType::class)
            ->add('nb_renew', HiddenType::class)
            ->add('endPublishedAt', HiddenType::class)
            ->add('status', HiddenType::class)
            ->add('stolenAt', DateType::class)
            ->add('reference', TextType::class)
            ->add('location', TextType::class)
            ->add('details', TextareaType::class)
            ->add('category', Category::class, [
                'choice_label' => 'category',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Annonce::class,
        ]);
    }
}
