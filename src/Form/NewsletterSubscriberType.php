<?php

namespace App\Form;

use App\Entity\NewsletterSubscriber;
use App\Entity\NewsletterTheme;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;

class NewsletterSubscriberType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('newsletterThemes', EntityType::class, [
                'class' => NewsletterTheme::class,
                'multiple' => true,
                'expanded' => true,
                'choice_label' => 'title',
                'label' => false,
            ])
            ->add('email', EmailType::class, [
                'attr' => ['placeholder' => 'gandalf@gmail.com'],
                'constraints' => [new Email()]
            ])
            ->add('submit', SubmitType::class, ['label' => 'Valider']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => NewsletterSubscriber::class,
        ]);
    }
}
