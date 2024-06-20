<?php

namespace App\Controller\Admin;

use App\Entity\Character;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class CharacterCrudController extends AbstractCrudController
{
    private string $uploadDir;
    private string $basePath;

    public function __construct(ParameterBagInterface $params)
    {
        $this->uploadDir = $params->get('upload_dir');
        $this->basePath = $params->get('base_path');
    }
    public static function getEntityFqcn(): string
    {
        return Character::class;
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle(Crud::PAGE_INDEX, 'Liste des Héros');
    }
    public function configureFields(
        string $pageName

    ): iterable {
        return [
            IdField::new('id')
                ->hideOnForm()
                ->hideOnIndex(),

            TextField::new('name', 'Nom'),
            TextField::new('gender', 'sexe'),

            TextField::new('ki', 'Ki'),
            TextField::new('maxKi', 'Max Ki'),
            TextField::new('race', 'Race'),
            TextEditorField::new('description', 'Description'),
            ImageField::new('image', 'Image')
                ->setUploadDir('public/uploads/characters')
                ->setBasePath('uploads/characters'),
            TextField::new('affiliation', 'Affiliation'),


        ];
    }
}
