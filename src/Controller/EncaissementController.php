<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EncaissementController extends AbstractController
{
    #[Route('/encaissement', name: 'app_encaissement')]
    public function index(): Response
    {
        return $this->render('encaissement/index.html.twig', [
            'controller_name' => 'EncaissementController',
        ]);
    }
}
