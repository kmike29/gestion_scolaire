<?php

namespace App\Controller\Admin;

use App\Entity\AnneeScolaire;
use App\Entity\Classe;
use App\Entity\ClasseAnneeScolaire;
use App\Entity\ClasseMatiere;
use App\Entity\Eleve;
use App\Entity\EmploiDuTemps;
use App\Entity\Matiere;
use App\Entity\Niveau;
use App\Entity\Personnel;
use App\Entity\TrancheHoraire;
use App\Entity\Tuteur;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
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
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Classes', 'fas fa-user-group', Classe::class);
        yield MenuItem::linkToCrud('Matières', 'fa-solid fa-book', Matiere::class);
        yield MenuItem::linkToCrud('Niveaux', 'fa fa-layer-group', Niveau::class);
        yield MenuItem::linkToCrud('Assignation des matières', 'fa fa-book-open', ClasseMatiere::class);
        yield MenuItem::linkToCrud('Eleves', 'fa fa-book-open-reader', Eleve::class);
        yield MenuItem::linkToCrud('Personnel', 'fa-solid fa-user-tie', Personnel::class);
        yield MenuItem::linkToCrud('Années scolaires', 'fa fa-calendar', AnneeScolaire::class);
        yield MenuItem::linkToCrud('Classes actives ', 'fa fa-people-group', ClasseAnneeScolaire::class);
        yield MenuItem::linkToCrud('Emplois du temps', 'fa fa-calendar-days', EmploiDuTemps::class);
        yield MenuItem::linkToCrud('Parents', 'fa fa-child-reaching', Tuteur::class);
        yield MenuItem::linkToCrud('Diplomes - inactif', 'fa fa-user-graduate', Eleve::class);
        yield MenuItem::linkToCrud('Matières programmés', 'fa fa-clock', TrancheHoraire::class);

    }
}
