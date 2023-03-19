<?php

namespace App\Controller\Admin;

use App\Entity\Crawler\Logs;
use Doctrine\Common\Collections\Criteria;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;

class LogsCrudController extends AbstractCrudController
{
    public function __construct(private readonly AdminUrlGenerator $adminUrlGenerator)
    {
    }

    public static function getEntityFqcn(): string
    {
        return Logs::class;
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
            ->showEntityActionsInlined()
            ->setDefaultSort(['createdAt' => Criteria::DESC])
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        yield DateTimeField::new('createdAt');
        yield DateTimeField::new('updatedAt');
        yield TextField::new('entity')
            ->formatValue(function (?string $value, Logs $entity) {
                if (null !== $value) {
                    $controller = match ($entity->getEntityType()) {
                        'software' => SoftwareCrudController::class,
                        default => null
                    };
                    if (null !== $controller) {
                        $url = $this->adminUrlGenerator
                            ->setController($controller)
                            ->setAction(Action::DETAIL)
                            ->setEntityId($entity->getEntityId())
                            ->generateUrl();

                        return sprintf(
                            '<a href="%s">%s #%s</a>',
                            $url,
                            $entity->getEntityType(),
                            $entity->getEntityId()
                        );
                    }
                }

                return null;
            })
        ;
        yield TextField::new('message');
    }
}
