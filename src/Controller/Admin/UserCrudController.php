<?php

namespace App\Controller\Admin;

use App\Entity\Character;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {

        return User::class;
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle(Crud::PAGE_INDEX, 'Liste des utilisateurs');
    }

    public function configureFields(string $pageName): iterable
    {

        return [

            TextField::new('firstName', 'Nom'),
            TextField::new('lastName', 'Prénom'),
            TextField::new('userName', 'Pseudo'),
            EmailField::new('email'),
            //TextField::new('password'),
            TextField::new('avatar'),
            ImageField::new('avatar', 'avatar')
                ->setUploadDir('public/assets/characters')
                ->setBasePath('public/assets/characters'),
            // Adding the character preference field as a dropdown.
            AssociationField::new('characterPref')
                ->setLabel('Mon héros préféré')
                ->setFormTypeOptions([
                    'class' => Character::class,
                    'choice_label' => 'name',
                ]),

        ];
    }


}
