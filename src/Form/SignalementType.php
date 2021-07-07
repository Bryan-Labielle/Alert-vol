<?php

namespace App\Form;

use App\Entity\Signalement;
use DateTime;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SignalementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $start = new DateTime();
        $builder
            ->add('details', CollectionType::class, [
                'entry_type' => CheckboxType::class,
                'label' => 'Quels  signes distinctifs avez-vous reconnu ?',
                'required' => false
            ])
            ->add('seenOn', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Véhicule vu le :',
                'attr' => ['class' => 'row-signalement'],
                'data' => $start
            ])
            /*->add('content', CollectionType::class, [
                'entry_type' => MessageType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'by_reference' => false,
                'allow_delete' => true,
            ])*/
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Signalement::class,
        ]);
    }
}
