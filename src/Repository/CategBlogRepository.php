<?php

namespace App\Repository;

use App\Entity\CategBlog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CategBlog|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategBlog|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategBlog[]    findAll()
 * @method CategBlog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategBlogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategBlog::class);
    }

    // /**
    //  * @return CategBlog[] Returns an array of CategBlog objects
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
    public function findOneBySomeField($value): ?CategBlog
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
