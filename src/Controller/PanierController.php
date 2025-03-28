<?php

namespace App\Controller;

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
        $id = $this->getUser()->getUserIdentifier();
        $produitRepository = $em->getRepository(Produit::class);
        $produits = $produitRepository->find($id);
        $args = array(
            'produits' => $produits,
        );
        return $this->render('panier/list.html.twig', $args);
    }
}
