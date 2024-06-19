<?php

namespace App\Controller\Admin;

use App\Entity\Contact;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ContactCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {



        return Contact::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle(Crud::PAGE_INDEX, 'Mes Message');
    }
    public function configureFields(string $pageName): iterable
    {
        return [

            IdField::new('id')
                ->hideOnIndex()
                ->hideOnForm(),
            TextField::new('firstName', 'Nom'),
            TextField::new('lastName', 'Prénom'),
            TextField::new('email'),
            TextField::new('subject', 'Sujet'),
            TextEditorField::new('message', 'Message')
        ];
    }

}
