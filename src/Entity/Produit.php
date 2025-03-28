<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Table(name: 'l3_produit')]
#[ORM\Entity(repositoryClass: ProduitRepository::class)]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $libelle = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Range(
        notInRangeMessage: 'le prix doit être compris entre {{ min }} et {{ max }}',
        min: 1,
        max: 999999.99,
    )]
    private ?float $prix = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Range(min: 0, minMessage: 'pas de stock négatif')]
    private ?int $quantiteEnStock = null;

    #[ORM\Column(name: 'enstock', type: Types::BOOLEAN, options: ['default' => true])]
    // paramètre "name" inutile ici car c'est déjà la valeur par défaut (c'est pour l'exemple)
        // idem pour le paramètre "type" (Types::BOOLEAN vaut 'boolean')
    #[Assert\Type(
        type: 'boolean',
        message: '{{ value }} n\'est pas de type {{ type }}',
    )]
    private ?bool $enstock = null;


    public function __construct(){
        $this->libelle = null;
        $this->prix = null;
        $this->enstock = false;
        $this->quantiteEnStock = 0;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): static
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getQuantiteEnStock(): ?int
    {
        return $this->quantiteEnStock;
    }

    public function setQuantiteEnStock(?int $quantiteEnStock): static
    {
        $this->quantiteEnStock = $quantiteEnStock;

        return $this;
    }

    public function isEnstock(): ?bool
    {
        return $this->enstock;
    }

    public function setEnstock(bool $enstock): static
    {
        $this->enstock = $enstock;

        return $this;
    }
}
