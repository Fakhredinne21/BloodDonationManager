<?php

namespace App\Form;

use App\Entity\BloodHoster;
use App\Entity\Donor;
use SebastianBergmann\CodeCoverage\Report\Text;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class DonorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('user',RegistrationFormType::class)
            ->add('lastname', TextType::class, [
                // Add constraints for password strength (optional)
                'constraints' => [
                    new Length(['min' => 8, 'max' => 255]),
                    // Add other password strength constraints as needed
                ],
            ]) ->add('firstname', TextType::class, [
                // Add constraints for password strength (optional)
                'constraints' => [
                    new Length(['min' => 8, 'max' => 255]),
                    // Add other password strength constraints as needed
                ],
            ])->add('phone', TextType::class, [
                // Add constraints for password strength (optional)
                'constraints' => [
                    new Length(['min' => 8, 'max' => 255]),
                    // Add other password strength constraints as needed
                ],
            ]) ->add('BloodType', ChoiceType::class, [
                'choices' => [
                    'A+' => 'A+',
                    'A-' => 'A-',
                    'B+' => 'B+',
                    'B-' => 'B-',
                    'O+' => 'o+',
                    'O-' => 'o-',
                ],
                'expanded' => false,  // Dropdown by default, set to true for radio buttons
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Sign Up',  // Customize submit button label
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Donor::class,
        ]);
    }
}
