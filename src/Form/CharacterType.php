<?php

namespace App\Form;

use App\Entity\Character;
use App\Entity\Planet;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CharacterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('ki')
            ->add('maxKi')
            ->add('race')
            ->add('description')
            ->add('image')
            ->add('affiliation')
            ->add('deletedAt')
            ->add('gender')
            ->add('transformation')
            ->add('planet', EntityType::class, [
                'class' => Planet::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Character::class,
        ]);
    }
}
