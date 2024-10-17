<?php

namespace App\Repository;

namespace App\Repository;

use App\Entity\Medecin;
use App\Entity\Rapport;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

class RapportRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Rapport::class);
    }

    public function findByMedecin(Medecin $medecin)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.medecin = :medecin')
            ->setParameter('medecin', $medecin)
            ->orderBy('r.date', 'DESC') // Optionnel : pour trier par date descendante
            ->getQuery()
            ->getResult();
    }

    public function findAllReportsWithPagination(int $page = 1, int $limit = 10): Paginator
    {
        $offset = ($page - 1) * $limit;

        $query = $this->createQueryBuilder('r')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery();

        return new Paginator($query, true);
    }
}
