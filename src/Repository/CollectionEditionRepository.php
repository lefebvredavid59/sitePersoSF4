<?php

namespace App\Repository;

use App\Entity\CollectionEdition;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CollectionEdition|null find($id, $lockMode = null, $lockVersion = null)
 * @method CollectionEdition|null findOneBy(array $criteria, array $orderBy = null)
 * @method CollectionEdition[]    findAll()
 * @method CollectionEdition[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CollectionEditionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CollectionEdition::class);
    }

    // /**
    //  * @return CollectionEdition[] Returns an array of CollectionEdition objects
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
    public function findOneBySomeField($value): ?CollectionEdition
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
