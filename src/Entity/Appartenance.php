<?php

namespace App\Entity;

use App\Repository\AppartenanceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AppartenanceRepository::class)]
class Appartenance
{
    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private User $user;

    #[ORM\ManyToOne(targetEntity: Pays::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Pays $pays;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    public function getPays(): Pays
    {
        return $this->pays;
    }

    public function setPays(Pays $pays): void
    {
        $this->pays = $pays;
    }
}
