<?php

namespace App\Controller\Admin;

use App\Entity\Crawler\Logs;
use App\Entity\Crawler\Software;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CrawlerDashboardController extends AbstractDashboardController
{
    #[Route('/crawler', name: 'crawler')]
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);

        return $this->redirect($adminUrlGenerator->setController(SoftwareCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Crawler');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToCrud('Software', 'fa fa-home', Software::class);
        yield MenuItem::linkToCrud('Logs', 'fa fa-home', Logs::class);
        yield MenuItem::linkToRoute('Configuration', 'fa fa-home', 'crawler_configuration');
        yield MenuItem::linkToRoute('Admin', 'fa fa-home', 'admin');
    }
}
