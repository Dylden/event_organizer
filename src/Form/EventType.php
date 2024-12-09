<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Establishment;
use App\Entity\Event;
use App\Entity\Room;
use App\Entity\Tag;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(child:'title', type: TextType::class, options: [
                'attr' => ['class' => 'form-control'],
                'label_attr' => ['class' => 'form-label'],
                'label' => 'Name of the Event'
            ])
            ->add('description', TextareaType::class, [
                'attr' => ['class' => 'form-control'],
                'label_attr' => ['class' => 'form-label'],
                'label' => 'Description'
            ])

            ->add('room', EntityType::class, [
                'class' => Room::class,
                'choice_label' => 'name',
                'multiple' => true,
                'attr' => ['room' => 'form-select'],
                'label' => 'Room',
                'label_attr' => ['room' => 'form-label'],
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'multiple' => true,
                'attr' => ['class' => 'form-select'],
                'label' => 'Category',
                'label_attr' => ['class' => 'form-label'],
            ])
            ->add('start_time', null, [
                'widget' => 'single_text'
            ])
            ->add('end_time', null, [
                'widget' => 'single_text'
            ])
            ->add('submit', SubmitType::class, [])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
