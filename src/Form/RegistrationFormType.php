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
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\IsTrue;

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
                'label' => 'Mon Pseudo*',
                "required" => true,

            ])
            ->add('firstName', TextType::class, [
                'label' => 'Mon Nom*',
                "required" => true,
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Mon Prénom*',
                "required" => true,
            ])
            ->add('email', EmailType::class, [
                'label' => 'Mon Email*',
                "required" => true,
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
            /*
            ->add('numAdress', TextType::class, [
                'label' => 'Numéro de rue',
                'required' => false,
            ])
            ->add('adress', TextType::class, [
                'label' => 'Rue/Avenue',
                'required' => false,
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville',
                'required' => false,
            ])
            ->add('zipcode', TextType::class, [
                'label' => 'Code postale',
                'required' => false,
            ])
            ->add('country', TextType::class, [
                'label' => 'Pays',
                'required' => false,
                'attr' => [
                    'placeholder' => 'France',
                ],
            ])
            // ->add('latitude', TextType::class, [
            //     'label' => 'latitude',
            //     ''
            // ])
            // ->add('longitude', TextType::class, [
            //     'label' => 'longitude',
            // ])
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
*/
            ->add('address', AddressType::class)

            ->add('characterPref', EntityType::class, [
                'label' => 'Mon héro préféré',
                'class' => Character::class,
                'choice_label' => 'name',
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Veuillez accepter les conditions d\'utilisation.',
                    ]),
                ],
            ])

            ->add(
                'submit',
                SubmitType::class,
                [
                    'label' => 'je m\'inscrire',
                    'attr' => ['class' => 'btn btn-primary bg-blue-500 p-2 w-full justify-center']
                ]
            ) //, 'label' => 'Je m\'inscrire'])

        ;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
