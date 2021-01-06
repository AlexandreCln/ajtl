<?php

namespace App\Form;

use App\Entity\PresentationPerson;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class PresentationPersonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        /** @var PresentationPerson|null $presentationPerson */
        $presentationPerson = $options['data'] ?? null;
        $isEdit = $presentationPerson && $presentationPerson->getId();

        $builder
            ->add('name', TextType::class, ['label' => 'Nom'])
            ->add('job', TextType::class, ['label' => 'Fonction']);

        $pictureConstraints = [
            new Image([
                // Think of increasing the upload_max_filesize parameter of PHP
                'maxSize' => '3M',
                'maxSizeMessage' => 'Ce fichier est trop volumineux (3MB maximum).'
            ])
        ];

        if (!$isEdit || !$presentationPerson->getPictureFilename()) {
            $pictureConstraints[] = new NotNull([
                'message' => 'Veuillez sélectionner une photo',
            ]);
        }

        $builder
            ->add('pictureFile', FileType::class, [
                'label' => 'Photo',
                'mapped' => false,
                'required' => false,
                'constraints' => $pictureConstraints
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PresentationPerson::class,
        ]);
    }
}
