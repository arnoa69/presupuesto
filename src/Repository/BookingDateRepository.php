<?php

namespace App\Repository;

use App\Entity\BookingDate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method BookingDate|null find($id, $lockMode = null, $lockVersion = null)
 * @method BookingDate|null findOneBy(array $criteria, array $orderBy = null)
 * @method BookingDate[]    findAll()
 * @method BookingDate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookingDateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BookingDate::class);
    }

    // /**
    //  * @return BookingDate[] Returns an array of BookingDate objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BookingDate
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
