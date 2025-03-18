<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class BienvenueController extends AbstractController
{
    #[Route('/bienvenue', name: 'app_bienvenue')]
    public function index(): Response
    {
        return $this->render('bienvenue/index.html.twig', [
            'controller_name' => 'BienvenueController',
        ]);
    }
}
