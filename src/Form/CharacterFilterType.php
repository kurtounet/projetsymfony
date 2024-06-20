<?php


namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\Planet;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CharacterFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'required' => false,
                'label' => 'Nom',
                'attr' => ['placeholder' => 'Nom']
            ])
            ->add('race', ChoiceType::class, [
                'required' => false,
                'label' => 'Race',
                'placeholder' => 'Choisissez sa Race',
                'choices' => [
                    'Frieza Race' => 'Frieza Race',
                    'Saiyan' => 'Saiyan',
                    'Majin' => 'Majin',
                    'Namekian' => 'Namekian',
                    'Android' => 'Android',
                    'Human' => 'Human',
                    'God' => 'God',
                    'Angel' => 'Angel',
                    'Unknown' => 'Unknown',
                    'Evil' => 'Evil',
                    'Nucleico benigno' => 'Nucleico benigno'
                ],

            ])

            ->add('affiliation', ChoiceType::class, [
                'required' => false,
                'label' => 'Affiliation',
                'choices' => [
                    'Army of Frieza' => 'Army of Frieza',
                    'Z Fighter' => 'Z Fighter',
                    'Villain' => 'Villain',
                    'Other' => 'Other',
                    'Assistant of Beerus' => 'Assistant of Beerus',
                    'Freelancer' => 'Freelancer',
                    'Pride Troopers' => 'Pride Troopers',
                    'Assistant of Vermoud' => 'Assistant of Vermoud'
                ],
                'placeholder' => 'Choisissez son affiliation'

            ])
            ->add('gender', ChoiceType::class, [
                'required' => false,
                'choices' => [
                    'Male' => 'Male',
                    'Female' => 'Female'
                ],
                'placeholder' => 'Choisissez un genre'
            ])
            ->add('planet', EntityType::class, [
                'class' => Planet::class,
                'choice_label' => 'name',
                'required' => false,
                'label' => 'Planète',
                'placeholder' => 'Choisissez une planète'
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Filtrer'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'method' => 'GET',
        ]);
    }
}