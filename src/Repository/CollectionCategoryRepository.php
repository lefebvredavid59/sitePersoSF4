<?php

namespace App\Repository;

use App\Entity\CollectionCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CollectionCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method CollectionCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method CollectionCategory[]    findAll()
 * @method CollectionCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CollectionCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CollectionCategory::class);
    }

    // /**
    //  * @return CollectionCategory[] Returns an array of CollectionCategory objects
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
    public function findOneBySomeField($value): ?CollectionCategory
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
