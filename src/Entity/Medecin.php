<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: "App\Repository\MedecinRepository")]
#[ORM\Table(name: "medecin")]
class Medecin
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private int $id;

    #[ORM\Column(type: Types::STRING, length: 30)]
    private string $nom;

    #[ORM\Column(type: Types::STRING, length: 30)]
    private string $prenom;

    #[ORM\Column(type: Types::STRING, length: 80)]
    private string $adresse;

    #[ORM\Column(type: Types::STRING, length: 15, nullable: true)]
    private ?string $tel = null;

    #[ORM\Column(type: Types::STRING, length: 50, nullable: true)]
    private ?string $specialitecomplementaire = null;

    #[ORM\Column(type: Types::INTEGER)]
    private int $departement;

    // Ajoutez vos getters et setters ici

    public function getId(): int
    {
        return $this->id;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }

    public function getPrenom(): string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): void
    {
        $this->prenom = $prenom;
    }

    public function getAdresse(): string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): void
    {
        $this->adresse = $adresse;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(?string $tel): void
    {
        $this->tel = $tel;
    }

    public function getSpecialitecomplementaire(): ?string
    {
        return $this->specialitecomplementaire;
    }

    public function setSpecialitecomplementaire(?string $specialitecomplementaire): void
    {
        $this->specialitecomplementaire = $specialitecomplementaire;
    }

    public function getDepartement(): int
    {
        return $this->departement;
    }

    public function setDepartement(int $departement): void
    {
        $this->departement = $departement;
    }
}
