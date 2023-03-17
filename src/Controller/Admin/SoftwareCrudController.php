<?php

namespace App\Controller\Admin;

use App\Entity\Software;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CodeEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class SoftwareCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Software::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->disable(Action::NEW, Action::EDIT, Action::DELETE)
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
        ;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // ...
            ->showEntityActionsInlined()
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name');
        yield BooleanField::new('active')
            ->renderAsSwitch(false);
        yield DateTimeField::new('createdAt');
        yield DateTimeField::new('updatedAt');

        if (Crud::PAGE_DETAIL === $pageName) {
            yield CodeEditorField::new('publiccodeYml');
            yield IdField::new('id');
            yield IdField::new('softwareUrlId');
        }
    }
}
