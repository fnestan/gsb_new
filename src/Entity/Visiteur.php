<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: "App\Repository\VisiteurRepository")]
#[ORM\Table(name: "visiteur")]
class Visiteur
{
    #[ORM\Id]
    #[ORM\Column(type: "string", length: 4)]
    private ?string $id = null;

    #[ORM\Column(type: "string", length: 30, nullable: true)]
    private ?string $nom = null;

    #[ORM\Column(type: "string", length: 30, nullable: true)]
    private ?string $prenom = null;

    #[ORM\Column(type: "string", length: 20, nullable: true)]
    private ?string $login = null;

    #[ORM\Column(type: "string", length: 20, nullable: true)]
    private ?string $mdp = null;

    #[ORM\Column(type: "string", length: 30, nullable: true)]
    private ?string $adresse = null;

    #[ORM\Column(type: "string", length: 5, nullable: true)]
    private ?string $cp = null;

    #[ORM\Column(type: "string", length: 30, nullable: true)]
    private ?string $ville = null;

    #[ORM\Column(name: "dateEmbauche", type: "date", nullable: true)]
    private ?\DateTimeInterface $dateEmbauche = null;

    #[ORM\Column(type: "bigint")]
    private int $timespan;

    #[ORM\Column(type: "string", length: 50, nullable: true)]
    private ?string $ticket = null;

    // Getters and Setters
    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;
        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): self
    {
        $this->prenom = $prenom;
        return $this;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(?string $login): self
    {
        $this->login = $login;
        return $this;
    }

    public function getMdp(): ?string
    {
        return $this->mdp;
    }

    public function setMdp(?string $mdp): self
    {
        $this->mdp = $mdp;
        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): self
    {
        $this->adresse = $adresse;
        return $this;
    }

    public function getCp(): ?string
    {
        return $this->cp;
    }

    public function setCp(?string $cp): self
    {
        $this->cp = $cp;
        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(?string $ville): self
    {
        $this->ville = $ville;
        return $this;
    }

    public function getDateEmbauche(): ?\DateTimeInterface
    {
        return $this->dateEmbauche;
    }

    public function setDateEmbauche(?\DateTimeInterface $dateEmbauche): self
    {
        $this->dateEmbauche = $dateEmbauche;
        return $this;
    }

    public function getTimespan(): int
    {
        return $this->timespan;
    }

    public function setTimespan(int $timespan): self
    {
        $this->timespan = $timespan;
        return $this;
    }

    public function getTicket(): ?string
    {
        return $this->ticket;
    }

    public function setTicket(?string $ticket): self
    {
        $this->ticket = $ticket;
        return $this;
    }
}