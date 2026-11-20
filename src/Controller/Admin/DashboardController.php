<?php

namespace App\Controller\Admin;

use App\Controller\Admin\AuteurCrudController;
use App\Controller\Admin\CategorieCrudController;
use App\Controller\Admin\EmpruntCrudController;
use App\Controller\Admin\ExemplaireCrudController;
use App\Controller\Admin\OeuvreCrudController;
use App\Controller\Admin\TypeOeuvreCrudController;
use App\Controller\Admin\UtilisateurCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    public function __construct(private AdminUrlGenerator $adminUrlGenerator)
    {
        $this->adminUrlGenerator = $adminUrlGenerator;
    }
    public function index(): Response
    {
        return $this->redirect(
            $this->adminUrlGenerator
                ->setController(OeuvreCrudController::class)
                ->setAction(Action::INDEX)
                ->generateUrl()
        );
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Mediatheque');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');

        // gestion de catalogue
        yield MenuItem::section('Catalogue');

        yield MenuItem::linkTo(OeuvreCrudController::class, 'Oeuvres', 'fas fa-book');
        yield MenuItem::linkTo(AuteurCrudController::class, 'Auteurs');
        yield MenuItem::linkTo(CategorieCrudController::class, 'Catégories');
        yield MenuItem::linkTo(TypeOeuvreCrudController::class, 'Type de\'oeuvre');

        // gestion des exemplaires
        yield MenuItem::section('Gestion des exemplaires');

        yield MenuItem::linkTo(ExemplaireCrudController::class, 'Exemplaires');

        // gestions des utilisateurs
        yield MenuItem::section('Gestion des adhérents');
        yield MenuItem::linkTo(UtilisateurCrudController::class, 'Utilisateurs');
        yield MenuItem::linkTo(EmpruntCrudController::class, 'Emprunts');
    }
}
