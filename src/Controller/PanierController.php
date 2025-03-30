<?php

namespace App\Controller;

use App\Entity\Panier;
use App\Entity\Produit;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PanierController extends AbstractController
{
    #[Route('/panier', name: 'app_panier')]
    public function index(): Response
    {
        return $this->render('panier/panier.html.twig', [
            'controller_name' => 'PanierController',
        ]);
    }

    public function viewAction(EntityManagerInterface $em): Response
    {
        $panierItems = $em->getRepository(Panier::class)->findBy([
            'user_id' => $this->getUser()->getId(),
        ]);

        $total = 0;
        foreach ($panierItems as $item) {
            $total += $item->getPrixUnitaire() * $item->getQuantite();
        }
        );
        return $this->render('panier/list.html.twig', $args);
    }
}
