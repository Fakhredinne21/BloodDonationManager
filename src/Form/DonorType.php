<?php

namespace App\Form;

use App\Entity\Donor;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class DonorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'constraints' => [
                    new Length(['min' => 2, 'max' => 255]),
                ],
                'attr' => ['placeholder' => 'First Name', 'required' => true]
            ])
            ->add('lastname', TextType::class, [
                'constraints' => [
                    new Length(['min' => 2, 'max' => 255]),
                ],
                'attr' => ['placeholder' => 'Last Name', 'required' => true]
            ])
            ->add('email', EmailType::class, [
                'constraints' => [
                    new Length(['min' => 5, 'max' => 255]),
                ],
                'attr' => ['placeholder' => 'email', 'required' => true]
            ])
            ->add('password', PasswordType::class, [
                'constraints' => [
                    new Length(['min' => 8, 'max' => 255]),
                ],
                'attr' => ['placeholder' => 'Password', 'required' => true]
            ])
            ->add('agree', CheckboxType::class, [
                'label' => 'Agree on terms and conditions',
                'required' => true
            ])
            ->add('phone', TextType::class, [
                'constraints' => [
                    new Length(['min' => 8]),
                ],
                'attr' => ['placeholder' => 'Phone Number', 'required' => true]
            ])
            ->add('bloodType', ChoiceType::class, [
                'choices' => [
                    'A+' => 'A+',
                    'A-' => 'A-',
                    'B+' => 'B+',
                    'B-' => 'B-',
                    'AB+' => 'AB+',
                    'AB-' => 'AB-',
                    'O+' => 'O+',
                    'O-' => 'O-',
                ],
                'placeholder' => 'Choose your blood type',
                'required' => true
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Sign Up',
                'attr' => ['class' => 'submit', 'style' => 'background-color: rgb(51, 58, 65);']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Donor::class,
        ]);
    }
}