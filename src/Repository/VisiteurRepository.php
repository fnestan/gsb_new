<?php

namespace App\Repository;

namespace App\Repository;

use App\Entity\Visiteur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class VisiteurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Visiteur::class);
    }

    public function findByVisitorByLoginAndPassword(String $login, String $password)
    {
        return $this->createQueryBuilder('v')
            ->Where('v.login = :login')
            ->setParameter('login', $login)
            ->andWhere('v.mdp = :password' )
            ->setParameter('password', $password)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
