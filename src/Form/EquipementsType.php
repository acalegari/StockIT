<?php

namespace App\Form;

use App\Entity\Categories;
use App\Entity\Equipements;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EquipementsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('canBeLoaned', ChoiceType::class, [
                'required' => 'true', 
               'choices'  => [
                    'Yes' => true,
                    'No' => false,
                ],
            ])
            ->add('image')
            ->add('categories', EntityType::class, [
                // looks for choices from this entity
                'class' => Categories::class,
                'choice_label' => 'name',
            ])
            ->add('description')
            ->add('createdAt', DateType::class,[
                
            ])
            ->add('submit', SubmitType::class, [
                'attr' => ['class' => 'submit'],
            ]);
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
