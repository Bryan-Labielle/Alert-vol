<?php

namespace App\Form;

use App\Entity\Annonce;
use App\Entity\User;
use App\Entity\Category;

use DateInterval;
use DateTime;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;


class AnnonceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $start = new DateTime();
        $end = $start->add(new DateInterval('P30D'));

        $builder
            ->add('title')
            ->add('description', TextareaType::class, [
                'required' => false,
            ])
            ->add('reference', TextType::class, [
                'required' => false,
            ])
            ->add('location', TextType::class, [
                'required' => false,
            ])
            ->add('details', CollectionType::class, [
                'required' => false,
            ])
            ->add('stolenAt', DateType::class, [
                'required' => false,
            ])
            /*->add('category', Category::class, [
                'choice_label' => 'category',
                'required' => false,
            ])*/
            ->add('category', ChoiceType::class, [
                'choices' => [
                    'BTP' => [
                        'engin de chantier'],
                    'Agroalimentaire' => [
                        'Moissonneuse-Bateuse'],
                    'Nautique' => [
                        'bateau sans permis'],
                ]
            ])
            ->add('owner', HiddenType::class, ['empty_data' => '1'])
            ->add('status', HiddenType::class, ['empty_data' => 0])
            ->add('nbRenew', HiddenType::class, ['empty_data' => 0])
            ->add('publishedAt', HiddenType::class, ['empty_data' => $start])
            ->add('endPublishedAt', HiddenType::class, ['empty_data' => $end]);
    }
        /*->add('title', TextType::class, [
            'required' => true])
        ->add('annonceImages', FileType::class, array(
            'label' => 'Photos (jpg, jpeg, png, pdf files)',
            'mapped' => true,
            'required' => true,
            'constraints' => [
                new File([
                    'maxSize' => '1024k',
                    'mimeTypes' => [
                        'application/jpg',
                        'application/jpeg',
                        'application/png',
                        'application/pdf',
                    ],
                    'mimeTypesMessage' => 'Please upload a valid document',])
            ]),*/

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Annonce::class,
        ]);
    }

}
