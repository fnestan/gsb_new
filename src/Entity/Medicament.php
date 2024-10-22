<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: "App\Repository\MedicamentRepository")]
#[ORM\Table(name: "medicament")]
class Medicament
{
    #[ORM\Id]
    #[ORM\Column(type: Types::STRING, length: 30)]
    private string $id;

    #[ORM\Column(name: "nomCommercial", type: Types::STRING, length: 80)]
    private string $nomCommercial;

    #[ORM\ManyToOne(targetEntity: Famille::class)]
    #[ORM\JoinColumn(name: "idFamille", referencedColumnName: "id")]
    private Famille $famille;

    #[ORM\Column(type: Types::STRING, length: 100)]
    private string $composition;

    #[ORM\Column(type: Types::STRING, length: 100)]
    private string $effets;

    #[ORM\Column(name: "contreIndications", type: Types::STRING, length: 100)]
    private string $contreIndications;

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getNomCommercial(): string
    {
        return $this->nomCommercial;
    }

    public function setNomCommercial(string $nomCommercial): void
    {
        $this->nomCommercial = $nomCommercial;
    }

    public function getFamille(): Famille
    {
        return $this->famille;
    }

    public function setFamille(Famille $famille): void
    {
        $this->famille = $famille;
    }

    public function getComposition(): string
    {
        return $this->composition;
    }

    public function setComposition(string $composition): void
    {
        $this->composition = $composition;
    }

    public function getEffets(): string
    {
        return $this->effets;
    }

    public function setEffets(string $effets): void
    {
        $this->effets = $effets;
    }

    public function getContreIndications(): string
    {
        return $this->contreIndications;
    }

    public function setContreIndications(string $contreIndications): void
    {
        $this->contreIndications = $contreIndications;
    }


}