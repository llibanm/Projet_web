<?php

namespace App\Form;

use App\Entity\Produit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle',
            TextType::class,
            [
                'label' => 'Libelle',
                'attr' => ['placeholder' => 'nom du produit'],
            ])
            ->add('prix',
                NumberType::class,     // déduit automatiquement par Symfony
                ['label' => 'prix d\'achat'])

            ->add('quantiteEnStock',
                IntegerType::class,    // déduit automatiquement par Symfony
                [
                    'label' => 'quantité en stock',
                    'help' => '0 si "enstock" est à "non"',           // message d'aide lié au champ
                ])
            ->add('enstock',
                ChoiceType::class,     // par défaut c'est CheckboxType
                [
                    'label' => 'en stock',
                    'choices' => ['oui' => true, 'non' => false],     // liste des choix : labels et valeurs
                    'expanded' => true,                               // liste déroulante ou radio-boutons
                ])



        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
