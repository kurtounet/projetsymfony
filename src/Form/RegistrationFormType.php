<?php

namespace App\Form;

use App\Entity\Character;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
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
            ->add('password', RepeatedType::class, [
                "type" => PasswordType::class,
                "invalid_message" => "Les mots de passes ne sont pas identiques. Reessayez",
                "options" => ["attr" => ["class" => "password-field"]],
                "required" => true,
                "first_options" => ["label" => "Mot de passe", "label_attr" => ["class" => "text-2xl"]],
                "second_options" => ["label" => "Confirmer le mot de passe", "label_attr" => ["class" => "text-2xl"]],
                "label_attr" => ["class" => "text-2xl"]
            ])
            // ->add('plainPassword', RepeatedType::class, [
            //     "type" => PasswordType::class,
            //     'mapped' => false,
            //     'attr' => ['autocomplete' => 'new-password'],
            //     'constraints' => [
            //         new NotBlank([
            //             'message' => "MERCI d'entrer un mot de passe",
            //         ]),
            //         new Length([
            //             'min' => 6,
            //             'minMessage' => 'Votre mot de passe doit contenir au moins {{ limit }} charactères',

            //             'max' => 4096,
            //         ]),
            //     ],
            // ])
            ->add('characterPref', EntityType::class, [
                'label' => 'Mon héro préféré',
                'class' => Character::class,
                'choice_label' => 'name',
            ])


            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
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
