<?php

namespace App\Form\Signalement;

use App\Entity\Signalement;
use App\Form\Signalement\MessageType;
use DateTime;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SignalementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
//            ->add('details', CollectionType::class, [
//                'entry_type' => CheckboxType::class,
//                'label' => 'Quels  signes distinctifs avez-vous reconnu ?',
//                'required' => false
//            ])
            ->add('seenOn', DateType::class, [
                'widget' => 'single_text',
                'attr' => ['class' => 'row-signalement'],
            ])
            ->add('submit', SubmitType::class)
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Signalement::class,
        ]);
    }
}
