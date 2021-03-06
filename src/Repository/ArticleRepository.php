<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function article($page)
    {
        $query = $this->createQueryBuilder('a')
            ->orderBy('a.created', 'DESC')
            ->setFirstResult(($page - 1) * 5)
            ->setMaxResults(5);

        return new Paginator($query, $fetchJoinCollection = true);
    }

    public function articleCateg($slug,$page)
    {
        $query = $this->createQueryBuilder('a')
            ->innerJoin('a.category','c')
            ->where('c.slug = :slug')
            ->setParameter('slug', $slug)
            ->orderBy('a.created', 'DESC')
            ->setFirstResult(($page - 1) * 5)
            ->setMaxResults(5);

        return new Paginator($query, $fetchJoinCollection = true);
    }

    public function articleHome()
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.created','DESC')
            ->setMaxResults(3)
            ->getQuery()
            ->getResult();
    }

    public function articleRand($numb)
    {
        return $this->createQueryBuilder('a')
            ->orderBy('RAND()')
            ->setMaxResults($numb)
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return Article[] Returns an array of Article objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Article
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
