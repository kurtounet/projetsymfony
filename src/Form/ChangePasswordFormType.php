<?php

namespace App\Form;

use App\Entity\Character;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Validator\Constraints\UserPasswordValidator;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlankValidator;

class ChangePasswordFormType extends AbstractType
{
    public function buildForm(
        FormBuilderInterface $builder,
        array $options
    ): void {

        $builder
            ->add('currentPassword', TextType::class, [
                'label' => 'Mot de passe actuel',

            ])
            ->add('newPassword', TextType::class, [
                'label' => 'Nouveau mot de passe',

            ])

            ->add('submit', SubmitType::class, [
                'label' => 'Modifier mon mot de passe',
            ]);


        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        // $resolver->setDefaults([
        //     'data_class' => User::class,
        // ]);
        $resolver->setDefaults([
            'method' => 'GET',
        ]);
    }
}
