<?php

namespace App\Controller\Admin;

use App\Entity\Planet;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PlanetCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Planet::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name', 'Name'),
            TextEditorField::new('description', 'Description'),
            ImageField::new('image', 'Image')
                ->setUploadDir('public/uploads/planets')
                ->setBasePath('uploads/planets'),
            BooleanField::new('deletedAt', 'Deleted At')
                ->hideOnForm()
                ->hideOnIndex(),

        ];
    }



    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle(Crud::PAGE_INDEX, 'Liste des planètes');
    }

}