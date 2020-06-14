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
            ->add('name', TextType::class, [
                'label' => 'Votre Nom',
                'required' => true,
                'constraints' => [new NotBlank(['message' => "Veuillez remplir ce champ."])]
            ])
            ->add('email_address', TextType::class, [
                'label' => 'Votre Email',
                'attr' => ['placeholder' => '(adresse à laquelle vous recontacter)'],
                'required' => true,
                'constraints' => [new Email(['message' => "Veuillez saisir une adresse email valide."])]
            ])
            ->add('text', TextareaType::class, [
                'label' => 'Message',
                'attr' => ['rows' => '6'],
                'required' => true,
                'constraints' => [new NotBlank(['message' => "Veuillez remplir ce champ."])]
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
