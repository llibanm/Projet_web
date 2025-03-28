<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $libelle = null;

    #[ORM\Column(nullable: true)]
    private ?float $prix = null;

    #[ORM\Column(nullable: true)]
    private ?int $quantiteEnStock = null;

    #[ORM\Column]
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
