<?php

namespace App\Form;

use App\Entity\AnnonceImage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class AnnonceImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('image', VichFileType::class, [
                'required' => true
            ])

            //TODO retirer nommage du fichier
            ->add('name', TextType::class, [
                'label' => "Nom de l'image"
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AnnonceImage::class,
        ]);
    }
}
