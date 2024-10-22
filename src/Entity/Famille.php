<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: "App\Repository\FamilleRepository")]
#[ORM\Table(name: "famille")]
class Famille
{
    #[ORM\Id]
    #[ORM\Column(type: Types::STRING, length: 10)]
    private string $id;

    #[ORM\Column(type: Types::STRING, length: 80)]
    private string $libelle;

    public function getId(): string
    {
        return $this->id;
    }

    public function getLibelle(): string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): void
    {
        $this->libelle = $libelle;
    }
}
