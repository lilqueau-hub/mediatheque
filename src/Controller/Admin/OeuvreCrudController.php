<?php

namespace App\Controller\Admin;

use App\Entity\Oeuvre;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class OeuvreCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Oeuvre::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('titre', 'Titre'),
            DateTimeField::new('dateSortie', 'Date de sortie')->renderAsChoice(),
            AssociationField::new('typeOeuvre', 'Type d\'oeuvre'),
            AssociationField::new('categories', 'Catégories'),
            AssociationField::new('auteurs', 'Auteurs')

        ];
    }
   
}
