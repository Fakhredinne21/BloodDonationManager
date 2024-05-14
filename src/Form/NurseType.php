<?php

namespace App\Form;

use App\Entity\Nurse;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class NurseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('last_name', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'label' => 'Last Name'
            ])
            ->add('first_name', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'label' => 'First Name'
            ])
            ->add('email', EmailType::class, [
                'attr' => ['class' => 'form-control'],
                'label' => 'Email'
            ])

            ->add('password', PasswordType::class, [
                'attr' => ['class' => 'form-control'],
                'label' => 'Password'
            ])
            ->add('phone', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'label' => 'Phone'
            ]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Nurse::class,
        ]);
    }
}