<?php

namespace App\Repository;

namespace App\Repository;

use App\Entity\Medicament;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

class MedicamentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Medicament::class);
    }

    public function findAllMedicinesWithPagination(int $page = null, int $limit = null,
                                                       $nameOrder = null, $name = null): Paginator
    {
        $offset = ($page - 1) * $limit;

        $query = $this->createQueryBuilder('m');
        if (!is_null($name)) {
            $query->Where('m.nomCommercial LIKE :name')
                ->setParameter('name', '%' . $name . '%');
        }
        if (!is_null($nameOrder)) {
            $query->orderBy("m.nomCommercial", strtoupper($nameOrder));
        }
        if (is_null($limit) && is_null($offset)) {
            $query->getQuery();

        } else {
            $query->setFirstResult($offset)
                ->setMaxResults($limit)
                ->getQuery();
        }


        return new Paginator($query, true);
    }
}
