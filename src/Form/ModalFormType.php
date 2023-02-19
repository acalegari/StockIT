<?php

namespace App\Form;

use App\Entity\Equipements;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModalFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'required'   => false,
                'constraints' => new Length(null, 2, 50),
            ])
            // ->add('categorie', ChoiceType::class,[

            // ])
            // ->add('isCanBeLoaned', CheckboxType::class,[
            //     'required' => true,
            // ])
            ->add('image',TextType::class, [
                'label' => false,
                'attr' => [
                    'label' => false,
                ]
            ])
            // ->add('save', ButtonType::class, [
            //     'attr' => ['class' => 'save'],
            // ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Equipements::class,
        ]);
    }
}