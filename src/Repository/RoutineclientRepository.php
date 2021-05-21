<?php

namespace App\Repository;

use App\Entity\Routineclient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Routineclient|null find($id, $lockMode = null, $lockVersion = null)
 * @method Routineclient|null findOneBy(array $criteria, array $orderBy = null)
 * @method Routineclient[]    findAll()
 * @method Routineclient[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RoutineclientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Routineclient::class);
    }

    // /**
    //  * @return Routineclient[] Returns an array of Routineclient objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Routineclient
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
