<?php

namespace App\Form;

use App\Entity\Categories;
use App\Entity\Equipements;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;


//FORM USED TO DISPLAY THE EQUIPEMENT SELECTED

class EquipementsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'required'   => false,
                'constraints' => new Length(null, 2, 50),
                'attr' => [
                    'label' => false,
                    'placeholder' => 'Nom de l\'équipement'
                ]
            ])
            ->add('categories', EntityType::class, [
                //add categorie list of the entity Categories
                'class' => Categories::class,
                'choice_label' => 'name',
                'attr' => [
                    'label' => false,
                    'placeholder' => 'Catégorie de l\'équipement :'
                ]
            ])
            ->add('canBeLoaned', ChoiceType::class, [
                "label" => "Disponible : ",
                'required' => 'true', 
                'choices'  => [
                    'Yes' => true,
                    'No' => false,
                ],
            ])
            ->add('description', TextareaType::class,[
                'label' => 'Description de l\'équipement',
                'required' => true,
            ])
            ->add('imagePath', FileType::class,  [
                'label' => 'Image (jpg, png file)',
                'multiple' => false,
                'data_class' => null,
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
