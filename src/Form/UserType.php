<?php

namespace App\Form;

use App\Entity\Character;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\TextEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('avatar', TextType::class, [
                'label' => 'Mon Avatar',
            ])
            ->add('userName', TextType::class, [
                'label' => 'Mon Pseudo',
            ])
            ->add('firstName', TextType::class, [
                'label' => 'Mon Nom',
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Mon Prénom',
            ])
            ->add('email', EmailType::class, [
                'label' => 'Mon Email',
            ])
            ->add('password', TextType::class, [
                'label' => 'Mon mot de passe',
            ])
            ->add('characterPref', EntityType::class, [
                'label' => 'Mon héro préféré',
                'class' => Character::class,
                'choice_label' => 'name',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
