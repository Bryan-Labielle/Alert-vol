<?php

namespace App\Form;

use App\Entity\SignalementImage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class SignalementImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('signalementFile', VichFileType::class, [
                'label' => 'Déposez votre image :',
                'attr' => ['class' => 'row-upload'],
                'required' => false
            ]);
           /* ->add('name')
            ->add('posted_at')
            ->add('updated_at')
            ->add('signalement')
        ;*/
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SignalementImage::class,
        ]);
    }
}
