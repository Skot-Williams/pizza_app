<?php

namespace App\Repository;

use App\Entity\PizzaPriceList;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PizzaPriceList|null find($id, $lockMode = null, $lockVersion = null)
 * @method PizzaPriceList|null findOneBy(array $criteria, array $orderBy = null)
 * @method PizzaPriceList[]    findAll()
 * @method PizzaPriceList[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PizzaPriceListRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PizzaPriceList::class);
    }

    // /**
    //  * @return PizzaPriceList[] Returns an array of PizzaPriceList objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PizzaPriceList
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
