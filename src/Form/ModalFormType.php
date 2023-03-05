<?php

namespace App\Form;

use App\Entity\Categories;
use App\Entity\Equipements;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\OptionsResolver\OptionsResolver;

//FORM USED ON THE HOME PAGE TO ADD EQUIPEMENT FROM MODAL
class ModalFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'required'   => false,
                'constraints' => new Length(null, 1, 25),
                'attr' => [
                    'class' => 'form-control input1',
                    'id' => 'equipementName',
                ]
            ])
            ->add('categories', EntityType::class, [
                'label' => 'Sélectionnez une catégorie',
                'class' => Categories::class,
                'choice_label' => 'name',
                'attr' => [
                    'name' => 'category',
                    'class' => 'form-control', 
                    'id' => 'selectCategory',
                ]
            ]) 
            ->add('canBeLoaned', ChoiceType::class, [
                'label' => 'Sélectionnez une disponibilité',
                'required' => 'true', 
                'choices'  => [
                    'Oui' => true,
                    'Non' => false,
                ],
                'attr' => [ 
                    'name' => 'disponibilite',
                    'class' => 'form-control', 
                    'id' => 'selectCategory',
                ]
            ])
            ->add('imagePath', FileType::class, [
                'label' => 'Image (jpg, png file)',
                'multiple' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        // 'maxSize' => '10024',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpeg',
                            'image/webp'
                        ],
                        'mimeTypesMessage' => 'Veuillez charger une image qui a pour extension img, png ou webp',
                    ])
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Ajouter', 
                'attr' => [
                    'class' => 'submit btn btn-success send',
                    'name' => 'addForm',
                    'id' => 'save' ,
                    'title' => 'save',
                ],
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