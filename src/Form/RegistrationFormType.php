<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

//REGISTRATION FORM

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('entreprise', TextType::class, [
            'required'   => false,
            'constraints' => new Length(null, 2, 50),
            'attr' => [
                'label' => false,
                'placeholder' => 'Votre entreprise'
            ]
        ])
        ->add('firstName', TextType::class, [
            'constraints' => new Length(null, 2, 30),
            'attr' => [
                'label' => false,
                'placeholder' => 'Votre prénom'
            ]
        ])
        ->add('lastName', TextType::class, [
            'constraints' => new Length(null, 2, 30),
            'attr' => [
                'label' => false,
                'placeholder' => 'Votre nom'
            ]
        ])
            ->add('email', EmailType::class, [
                'constraints' => new Length(null, 5, 30),
                'attr' => [
                    'label' => false,
                    'placeholder' => 'Votre email' 
                ]
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'label' => 'Acceptez les termes', 
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter les thermes',
                    ]),
                ],
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Le mot de passe et la confirmation doivent être identique!',
                'required' => true,
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'first_options' => [
                    'attr' => [
                        'placeholder' => 'Merci de saisir votre mot de passe'
                    ]
                 ],
                 'second_options' => [
                    'attr' => [
                        'placeholder' => 'Merci de confirmer votre mot de pase!'
                    ]
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre password doit contenir au minimum {{ limit }} caractères',
                        'max' => 4096,
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
