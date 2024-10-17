<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: "rapport")]
#[ORM\Entity(repositoryClass: "App\Repository\RapportRepository")]
class Rapport
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(type: "date", nullable: true)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(type: "string", length: 100, nullable: true)]
    private ?string $motif = null;

    #[ORM\Column(type: "string", length: 100, nullable: true)]
    private ?string $bilan = null;

    #[ORM\ManyToOne(targetEntity: Visiteur::class)]
    #[ORM\JoinColumn(name: "idVisiteur", referencedColumnName: "id")]
    private ?Visiteur $visiteur = null;

    #[ORM\ManyToOne(targetEntity: Medecin::class)]
    #[ORM\JoinColumn(name: "idMedecin", referencedColumnName: "id")]
    private ?Medecin $medecin = null;

    // Getters and Setters

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;
        return $this;
    }

    public function getMotif(): ?string
    {
        return $this->motif;
    }

    public function setMotif(?string $motif): self
    {
        $this->motif = $motif;
        return $this;
    }

    public function getBilan(): ?string
    {
        return $this->bilan;
    }

    public function setBilan(?string $bilan): self
    {
        $this->bilan = $bilan;
        return $this;
    }

    public function getVisiteur(): ?Visiteur
    {
        return $this->visiteur;
    }

    public function setVisiteur(?Visiteur $visiteur): void
    {
        $this->visiteur = $visiteur;
    }

    public function getMedecin(): ?Medecin
    {
        return $this->medecin;
    }

    public function setMedecin(?Medecin $medecin): self
    {
        $this->medecin = $medecin;
        return $this;
    }
}