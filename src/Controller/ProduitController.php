<?php

namespace App\Controller;

use App\Entity\Panier;
use App\Entity\Produit;
use App\Form\ProduitPanierType;
use App\Form\ProduitType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/produit', name: 'produit')]
class ProduitController extends AbstractController
{
    #[Route('', name: '')]
    public function indexAction(): Response
    {
        return $this->redirectToRoute('produit_list', ['page' => 1]);
    }

    #[Route('/add', name: '_produit_add')]
    #[IsGranted('ROLE_ADMIN')]
    public function filmAddAction(EntityManagerInterface $em, Request $request): Response
    {
        $produit = new Produit();

        $form = $this->createForm(ProduitType::class, $produit);
        $form->add('send', SubmitType::class, ['label' => 'add produit']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $em->persist($produit);
            $em->flush();
            $this->addFlash('info', 'ajout produit réussi');
            return $this->redirectToRoute('accueil_index');
        }

        if ($form->isSubmitted())
            $this->addFlash('info', 'formulaire ajout produit incorrect');

        $args = array(
            'myform' => $form
        );
        return $this->render('produit/produit_add.html.twig', $args);
    }

    #[Route('/list', name: 'liste_produit')]
    public function listAction(EntityManagerInterface $em, Request $request): Response
    {
        $produits = $em->getRepository(Produit::class)->findAll();
        $forms = [];

        foreach ($produits as $produit) {
            $panier = $em->getRepository(Panier::class)->findOneBy([
                'user' => $this->getUser(),
                'produit' => $produit
            ]);

            if (!$panier) { // on vérifie si le produit n'exister pas déjà dans lepanier
                $panier = new Panier();
                $panier->setUser($this->getUser());
                $panier->setProduit($produit);
                $panier->setQuantite(0);
            }

            //génère un formulaire que si le produit est en stock
            if ($produit->getQuantiteEnStock() > 0) {
                $form = $this->createForm(ProduitPanierType::class, $panier);
                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {
                    $quantiteChoisie = $form->get('quantite')->getData();

                    if ($quantiteChoisie > 0) {
                        $produit->setQuantiteEnStock($produit->getQuantiteEnStock() - $quantiteChoisie);

                        if ($produit->getQuantiteEnStock() <= 0) {
                            $produit->setEnstock(false);
                        }

                        $panier->setQuantite($panier->getQuantite() + $quantiteChoisie);

                        $em->persist($produit);
                        $em->persist($panier);
                        $em->flush();


                    }

                    return $this->redirect($request->getUri());

                }

                $forms[$produit->getId()] = $form->createView();
            } else {
                // Produit hors stock : pas de formulaire
                $forms[$produit->getId()] = null;
            }
        }

        return $this->render('produit/list.html.twig', [
            'produits' => $produits,
            'forms' => $forms,
        ]);
    }

}
