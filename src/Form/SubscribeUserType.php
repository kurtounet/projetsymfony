<?php

namespace App\Form;

use App\Entity\Character;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\TextEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Mime\I;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SubscribeUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('avatar', FileType::class, [
                'label' => 'Mon Avatar',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new Image()
                ]
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

            ->add('password', PasswordType::class, [
                'label' => 'Mon mots de passe',
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
