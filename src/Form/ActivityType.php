<?php

namespace App\Form;

use App\Entity\Activity;
use App\Entity\Adminbyplace;
use App\Entity\Donor;
use App\Entity\Nurse;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActivityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('status',ChoiceType::class, [
                'choices'  => [
                    'Online' => true,
                    'Offline' => false,
                ]
            ])
            ->add('nameActivity')
            ->add('description')
//            ->add('donors', EntityType::class, [
//                'class' => Donor::class,
//                'choice_label' => 'id',
//                'multiple' => true,
//            ])
            ->add('nurses', EntityType::class, [
                'class' => Nurse::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Activity::class,
        ]);
    }
}
