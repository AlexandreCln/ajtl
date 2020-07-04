<?php

namespace App\Form;

use App\Entity\NewsletterTheme;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;

class NewsletterSendType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('theme', EntityType::class, [
                'class' => NewsletterTheme::class,
                'required' => true,
                'choice_label' => 'title',
                'label' => 'Thème'
            ])
            ->add('file', FileType::class, [
                'label' => 'Image',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '2000k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/jpg',
                            'image/png',
                            'image/webp'
                        ],
                        'mimeTypesMessage' => 'Veuillez choisir une image au format JPEG ou PNG.',
                        'maxSizeMessage' => 'Cette image est trop lourde (2000ko max).'
                    ])
                ],
            ])
            ->add('subject', TextType::class, [
                'required' => true,
                'label' => 'Sujet'
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Message',
                'required' => false,
                'attr' => ['placeholder' => '(optionnel)']
            ])
        ;
    }
}
