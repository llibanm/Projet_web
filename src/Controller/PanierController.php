<?php

namespace App\Controller;

use App\Entity\Panier;
use App\Entity\Produit;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
#[Route('/panier', name: 'panier')]
final class PanierController extends AbstractController
{
    #[Route('/', name: 'app_panier')]
    public function panierAction(EntityManagerInterface $em, Request $request): Response
    {
        // Récupérer les produits dans le panier de l'utilisateur actuel
        $panierUser = $em->getRepository(Panier::class)->findBy([
            'user' => $this->getUser()->getId()
        ]);

        $totalPrix = 0;
        foreach ($panierUser as $panier) {
            $prixProduit = $panier->getProduit()->getPrix();
            $quantite = $panier->getquantite();

            // Calcul du prix total pour cet article
            $prixTotalArticle = $prixProduit * $quantite;
            $totalPrix += $prixTotalArticle;
        }

        return $this->render('panier/panier.html.twig', [
            'panierUser' => $panierUser,
            'total' => $totalPrix,
        ]);
    }

    #[Route('/supprimer/{id}', name: 'panier_supprimer', methods: ['POST'])]
    public function supprimerProduitDuPanier(int $id, EntityManagerInterface $em): Response
    {
        $panierUser = $em->getRepository(Panier::class)->findBy([
            'user' => $this->getUser()->getId()
        ]);

        foreach ($panierUser as $panier) {
            if ($panier->getProduit() === $id) {
                $produit = $panier->getProduit();
                $produit->setQuantiteEnStock($produit->getQuantiteEnStock() + $panier->getQuantite());
                $em->persist($produit);
                $em->remove($panier);
                $em->flush();
            }
        }

        return $this->redirectToRoute('panier'); // Rediriger vers la page du panier après suppression
    }

    #[Route('/vider', name: 'panier_vider')]
    public function viderPanier(EntityManagerInterface $em): Response
    {
        $panierItems = $em->getRepository(Panier::class)->findBy([
            'user' => $this->getUser(),
        ]);

        foreach ($panierItems as $item) {
            // Remettre à jour la quantité en stock pour chaque produit
            $produit = $item->getProduit();
            $produit->setQuantiteEnStock($produit->getQuantiteEnStock() + $item->getQuantite());

            // Supprimer l'élément du panier
            $em->remove($item);
        }

        $em->flush();

        // Rediriger vers la page du panier
        return $this->redirectToRoute('panier');
    }

    #[Route('/commander', name: 'panier_commander')]
    public function commander(EntityManagerInterface $em): Response
    {
        $panierItems = $em->getRepository(Panier::class)->findBy([
            'user' => $this->getUser(),
        ]);

        // Supprimer tous les produits du panier sans toucher aux quantités en stock
        foreach ($panierItems as $item) {
            $em->remove($item);
        }

        $em->flush();

        // Rediriger vers la page du panier (panier vide)
        return $this->redirectToRoute('panier');
    }

    #[Route('/voirpanier', name: '_panier')]
    public function voirPanier(EntityManagerInterface $em): Response
    {
        $panierItems = $em->getRepository(Panier::class)->findBy([
            'user' => $this->getUser(),
        ]);

        $args = array(
            'panierItems' => $panierItems,
        );

        return $this->render('panier/panier.html.twig', $args);
    }

}
