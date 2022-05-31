<?php

namespace App\Repository;

use App\Entity\CollectionFamily;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CollectionFamily|null find($id, $lockMode = null, $lockVersion = null)
 * @method CollectionFamily|null findOneBy(array $criteria, array $orderBy = null)
 * @method CollectionFamily[]    findAll()
 * @method CollectionFamily[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CollectionFamilyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CollectionFamily::class);
    }

    // /**
    //  * @return CollectionFamily[] Returns an array of CollectionFamily objects
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
    public function findOneBySomeField($value): ?CollectionFamily
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
