<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * Set user with the given user id to be target. Set target value of all other users to 0
     * @param int $userId
     */
    public function setTarget(int $userId)
    {
        $this->getEntityManager()
            ->createQuery('UPDATE App\Entity\User u SET u.isTarget = CASE WHEN u.id=:userId THEN 1 ELSE 0 END')
            ->setParameter('userId', $userId)
            ->getResult();
    }

    /**
     * @return User|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getTargetUser(): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.isTarget = 1')
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }
}
