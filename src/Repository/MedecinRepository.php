<?php

namespace App\Repository;

namespace App\Repository;

use App\Entity\Medecin;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

class MedecinRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Medecin::class);
    }

    public function findAllDoctorsWithPagination(int $page = 1, int $limit = 10, $lastnameOrder = null,
                                                     $firstnameOrder = null, $name = null): Paginator
    {
        $offset = ($page - 1) * $limit;

        $query = $this->createQueryBuilder('m');
        if (!is_null($name)) {
            $query->Where('m.nom LIKE :name')
                ->setParameter('name', '%' . $name . '%');
        }
        if (!is_null($firstnameOrder)) {
            $query->orderBy("m.prenom", strtoupper($firstnameOrder));
        }
        if (!is_null($lastnameOrder)) {
            $query->orderBy("m.nom", strtoupper($lastnameOrder));
        }
        $query->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery();

        return new Paginator($query, true);
    }

}
