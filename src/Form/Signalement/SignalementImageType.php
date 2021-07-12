<?php

namespace App\Form\Signalement;

use App\Entity\SignalementImage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class SignalementImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('signalementFile', VichFileType::class, [
                'label' => false,
                'attr' => ['class' => 'row-upload'],
                'allow_delete' => false,
                'download_label' => '',
                'required' => false
            ])
            ->add('delete', ButtonType::class, [
                'attr' => ['class' => 'btn btn-danger btn-sm remove_item_link'],
                'label_html' => true,
                'label' => '<i class="fas fa-trash"></i> retirer'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SignalementImage::class,
        ]);
    }
}
