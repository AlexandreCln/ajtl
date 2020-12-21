<?php

namespace App\Form;

use App\Entity\Presentation;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PresentationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('coreUsers', EntityType::class, [
                'class' => User::class,
                'label' => 'Membres de l\'association',
            ])
            ->add('aboutText', TextareaType::class, ['label' => 'À propos'])
            ->add('generalText', TextareaType::class, ['label' => 'Informations générales']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Presentation::class,
        ]);
    }
}
