<?php

namespace App\Repository;

use App\Entity\ProductPosition;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ProductPosition|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductPosition|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductPosition[]    findAll()
 * @method ProductPosition[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductPositionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductPosition::class);
    }

    // /**
    //  * @return ProductPosition[] Returns an array of ProductPosition objects
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
    public function findOneBySomeField($value): ?ProductPosition
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
