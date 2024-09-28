<?php

namespace App\Controller\Admin;

use App\Entity\AnneeScolaire;
use App\Entity\Classe;
use App\Entity\ClasseAnneeScolaire;
use App\Entity\ClasseMatiere;
use App\Entity\Eleve;
use App\Entity\EmploiDuTemps;
use App\Entity\Inscription;
use App\Entity\Matiere;
use App\Entity\Niveau;
use App\Entity\Paiement;
use App\Entity\Personnel;
use App\Entity\Remise;
use App\Entity\TrancheHoraire;
use App\Entity\Tuteur;
use App\Entity\TypeRemise;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/', name: 'admin')]
    public function index(): Response
    {
        $routeBuilder = $this->container->get(AdminUrlGenerator::class);
        $url = $routeBuilder->setController(ClasseCrudController::class)->generateUrl();

        return $this->redirect($url);
        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTranslationDomain('admin')
            ->setTitle('Gestion scolaire')
            ->setLocales(['fr']);
    }

    public function configureMenuItems(): iterable
    {

        return [
            MenuItem::linkToCrud('Eleves', 'fa fa-book-open-reader', Eleve::class),
            MenuItem::linkToCrud('Inscriptions', 'fa fa-clock', Inscription::class),
            MenuItem::linkToCrud('Paiements', 'fa fa-money-bill', Paiement::class),

            MenuItem::linkToDashboard('Dashboard', 'fa fa-home'),
            MenuItem::subMenu('Système', 'fa fa-article')->setSubItems([
                MenuItem::linkToCrud('Classes', 'fas fa-user-group', Classe::class),
                MenuItem::linkToCrud('Matières', 'fa-solid fa-book', Matiere::class),
                MenuItem::linkToCrud('Niveaux', 'fa fa-layer-group', Niveau::class),
                MenuItem::linkToCrud('Assignation des matières', 'fa fa-book-open', ClasseMatiere::class),
                MenuItem::linkToCrud('Années scolaires', 'fa fa-calendar', AnneeScolaire::class),
                MenuItem::linkToCrud('Type de Remises', 'fa fa-clock', TypeRemise::class),
                MenuItem::linkToCrud('Matières programmés', 'fa fa-clock', TrancheHoraire::class),
                MenuItem::linkToCrud('Remises', 'fa fa-clock', Remise::class),


            ]),
            MenuItem::subMenu('Gestion des classes', 'fa fa-article')->setSubItems([
                MenuItem::linkToCrud('Personnel', 'fa-solid fa-user-tie', Personnel::class),
                MenuItem::linkToCrud('Diplomes - inactif', 'fa fa-user-graduate', Eleve::class),
                MenuItem::linkToCrud('Classes actives ', 'fa fa-people-group', ClasseAnneeScolaire::class),
                MenuItem::linkToCrud('Emplois du temps', 'fa fa-calendar-days', EmploiDuTemps::class),

            ]),


        ];


    }
}
