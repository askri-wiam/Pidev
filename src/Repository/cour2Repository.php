<?php

namespace App\Repository;

use App\Entity\Cour2;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Cour2|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cour2|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cour2[]    findAll()
 * @method Cour2[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class cour2Repository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cour2::class);
    }

    // /**
    //  * @return Cour2[] Returns an array of Cour2 objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Cour2
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
