<?php

namespace App\Form;

use App\Entity\Character;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use App\Entity\Type;

class CharacterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, ['label' => 'Nom'])
            ->add('birthdate', DateType::class, array(
                'years' => range(date('Y'), date('Y') - 500), 'label' => 'Date de naissance',
                'placeholder' => [
                    'year' => 'Année', 'month' => 'Mois', 'day' => 'jour',
                ],
                'format' => 'ddMMyyyy',
            ))
            ->add('description', TextType::class, ['label' => 'Description'])
            ->add('level', IntegerType::class, ['label' => 'Niveau'])
            ->add('experience', IntegerType::class, ['label' => 'Experience'])
            ->add('health', IntegerType::class, ['label' => 'Points de vie'])
            ->add('Type', null, ['label' => 'Classe'])
            ->add('skill', null, ['label' => 'Compétences'])
            ->add('profilPicture', FileType::class, [
                'label' => 'image de profil',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '10000k',
                        'mimeTypes' => [
                            'image/jpg',
                            'image/jpeg',
                            'image/png'
                        ],
                        'mimeTypesMessage' => 'veuillez upload une image jpg/jpeg/png'
                    ])
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Character::class,
        ]);
    }
}
