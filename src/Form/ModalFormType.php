<?php

namespace App\Form;

use App\Entity\Equipements;
use App\Entity\Categories;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
// ...

class SportMeetupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('sport', EntityType::class, [
                'class' => Sport::class,
                'placeholder' => '',
            ])
        ;

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) {
                $form = $event->getForm();

                // this would be your entity, i.e. SportMeetup
                $data = $event->getData();

                $sport = $data->getSport();
                $positions = null === $sport ? [] : $sport->getAvailablePositions();

                $form->add('position', EntityType::class, [
                    'class' => Position::class,
                    'placeholder' => '',
                    'choices' => $positions,
                ]);
            }
        );
    }

    // ...
}