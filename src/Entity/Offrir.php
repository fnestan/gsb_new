<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: "App\Repository\OffrirRepository")]
#[ORM\Table(name: "offrir")]
class Offrir
{
    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Rapport::class)]
    #[ORM\JoinColumn(name: "idRapport", referencedColumnName: "id")]
    private Rapport $rapport;

    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Medicament::class)]
    #[ORM\JoinColumn(name: "idMedicament", referencedColumnName: "id")]
    private Medicament $medicament;

    #[ORM\Column(type: "integer", nullable: true)]
    private int $quantite ;

    // Getters and Setters
    public function getRapport(): ?Rapport
    {
        return $this->rapport;
    }

    public function setRapport(Rapport $rapport): self
    {
        $this->rapport = $rapport;
        return $this;
    }

    public function getMedicament(): ?Medicament
    {
        return $this->medicament;
    }

    public function setMedicament(Medicament $medicament): self
    {
        $this->medicament = $medicament;
        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(?int $quantite): self
    {
        $this->quantite = $quantite;
        return $this;
    }
}