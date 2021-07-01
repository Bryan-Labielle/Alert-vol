<?php

namespace App\Form;

use App\Entity\Message;
use App\Entity\Signalement;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
        $builder
            ->add('details', CollectionType::class, [
                'entry_type' => CheckboxType::class,
                'label' => 'Quels  signes distinctifs avez-vous reconnu ?'
            ])
            ->add('seenOn', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Véhicule vu le :'
            ])
            /*->add('content', EntityType::class, [
                'class' => Message::class,
                'choice_label' =>  'content',
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
