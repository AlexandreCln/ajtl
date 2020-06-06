<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email_address', TextType::class, [
                'label' => 'Email',
                'required' => true,
                'constraints' => [new Email(['message' => "Veuillez saisir une adresse email valide."])]
            ])
            ->add('subject', TextType::class, [
                'label' => 'Sujet',
                'required' => false,
                'constraints' => [new Length(['max' => 40, 'maxMessage' => 'Le sujet ne doit pas dépasser 40 caractères.'])]
            ])
            ->add('text', TextareaType::class, [
                'label' => 'Message',
                'attr' => ['rows' => '6'],
                'required' => true,
                'constraints' => [new NotBlank(['message' => "Veuillez remplir ce champ."])]
                ])
            ->add('send', SubmitType::class, [
                'label' => 'Envoyer',
                'attr' => ['class' => 'btn btn-primary-dark']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
