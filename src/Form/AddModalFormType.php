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
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;

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
            ->add('image', TextType::class, [
                'required'   => false,
            ])
            ->add('imagePath', FileType::class, [
                'label' => 'Image (jpg, png file)',
                'multiple' => false,

                // unmapped means that this field is not associated to any entity property
                // 'mapped' => true,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
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
                ],
            ])
            // ...
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