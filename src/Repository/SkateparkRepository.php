<?php

namespace App\Repository;

use App\Entity\Skatepark;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Skatepark|null find($id, $lockMode = null, $lockVersion = null)
 * @method Skatepark|null findOneBy(array $criteria, array $orderBy = null)
 * @method Skatepark[]    findAll()
 * @method Skatepark[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SkateparkRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Skatepark::class);
    }

    // /**
    //  * @return Skatepark[] Returns an array of Skatepark objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Skatepark
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
