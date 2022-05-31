<?php

namespace App\Repository;

use App\Entity\CollectionSubcategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CollectionSubcategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method CollectionSubcategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method CollectionSubcategory[]    findAll()
 * @method CollectionSubcategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CollectionSubcategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CollectionSubcategory::class);
    }

    // /**
    //  * @return CollectionSubcategory[] Returns an array of CollectionSubcategory objects
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
    public function findOneBySomeField($value): ?CollectionSubcategory
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
