<?php

namespace App\Controller\Admin;

use App\ApiClient;
use App\Entity\Crawler\Publisher;
use App\Form\PublisherCodeHostingType;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PublisherCrudController extends AbstractCrudController
{
    public function __construct(private readonly ApiClient $apiClient)
    {
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        assert($entityInstance instanceof Publisher);
        try {
            $this->apiClient->createPublisher($entityInstance);
            $this->addFlash('success', sprintf('Publisher %s created', $entityInstance->getAlternativeId() ?: $entityInstance->getDescription()));
        } catch (\Exception $exception) {
            $this->addFlash('danger', $exception->getMessage());
        }
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        assert($entityInstance instanceof Publisher);
        try {
            $this->apiClient->updatePublisher($entityInstance);
            $this->addFlash('success', sprintf('Publisher %s updated', $entityInstance->getAlternativeId() ?: $entityInstance->getDescription()));
        } catch (\Exception $exception) {
            $this->addFlash('danger', $exception->getMessage());
        }
    }

    public function deleteEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        assert($entityInstance instanceof Publisher);
        try {
            $this->apiClient->deletePublisher($entityInstance);
            $this->addFlash('success', sprintf('Publisher %s deleted', $entityInstance->getAlternativeId() ?: $entityInstance->getDescription()));
        } catch (\Exception $exception) {
            $this->addFlash('danger', $exception->getMessage());
        }
    }

    public static function getEntityFqcn(): string
    {
        return Publisher::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
//            ->disable(Action::NEW, Action::EDIT, Action::DELETE)
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
        ;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->showEntityActionsInlined()
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('description');
        yield TextField::new('alternativeId');
        yield TextField::new('email');
        yield BooleanField::new('active')
            ->renderAsSwitch(false);
        yield CollectionField::new('codeHosting')
            ->setEntryType(PublisherCodeHostingType::class)
            ->renderExpanded();
    }
}
