<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('num', TextType::class, ['label' => 'N°'])
            ->add('street', TextType::class, ['label' => 'Rue'])
            ->add('zipcode', TextType::class, ['label' => 'Code Postal'])
            ->add('city', TextType::class, ['label' => 'Ville'])
            ->add('country', TextType::class, ['label' => 'Pays'])
            // ->add('latitude', TextType::class)
            // ->add('longitude', TextType::class)
        ;
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
