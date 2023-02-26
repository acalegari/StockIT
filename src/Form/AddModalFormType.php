<?php

namespace App\Form;

use App\Entity\Categories;
use App\Entity\Equipements;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AddModalFormType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'required'   => false,
            ])
            ->add('categories', EntityType::class, [
                // looks for choices from this entity
                'class' => Categories::class,
                'choice_label' => 'name',
            ])
            ->add('canBeLoaned', ChoiceType::class, [
                    'required' => 'true', 
                   'choices'  => [
                        'Yes' => true,
                        'No' => false,
                ],
            ])
            ->add('image',TextType::class, [
                'label' => false,
                'attr' => [
                    'label' => false,
                ]
            ])
            ->add('submit', SubmitType::class, [
                'attr' => ['class' => 'submit'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null,
            'data_class' => Equipements::class,
        ]);
    }
}