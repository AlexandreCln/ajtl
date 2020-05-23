<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;

class NewsletterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('choice1', CheckboxType::class, [
                'label' => 'Jeux de Rôles & Grandeur Nature',
                'required' => false])
            ->add('choice2', CheckboxType::class, [
                'label' => 'Jeux de Plateau & Mah-Jong',
                'required' => false])
            ->add('choice3', CheckboxType::class, [
                'label' => 'Jeux Plein Air & Projections Vidéos',
                'required' => false])
            ->add('email', EmailType::class, [
                'attr' => ['placeholder' => 'gandalf@gmail.com'],
                'constraints' => [new Email()]
            ])
            ->add('submit', SubmitType::class, ['label' => 'Valider']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
