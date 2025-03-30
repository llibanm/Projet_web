<?php

namespace App\Form;

use App\Entity\Panier;
use App\Entity\Produit;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProduitPanierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var Panier|null $panier */
        $panier = $options['data'] ?? null;
        $produit = $panier ? $panier->getProduit() : null;

        $quantitePanier = $panier ? $panier->getQuantite() : 0;
        $quantiteStock = $produit ? $produit->getQuantiteEnStock() : 0;

        // Définition des choix pour la liste déroulante
        $min = -$quantitePanier; // Permet de retirer jusqu'à la quantité déjà commandée
        $max = $quantiteStock; // Maximum = stock disponible
        $choices = range($min, $max);

        $builder
            ->add('produit', HiddenType::class, [
                'data' => $produit ? $produit->getId() : null,
                'mapped' => false,
            ])
            ->add('quantite', ChoiceType::class, [
                'choices' => array_combine($choices, $choices), // Clés = valeurs
                'data' => 0, // Valeur par défaut
                'label' => 'Quantité',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Panier::class, // Associe ce formulaire à l'entité Panier
        ]);
    }
}
