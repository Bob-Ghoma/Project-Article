<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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
    /**
     * @return Article[]
     */
    public function getThisYearArticles(){
        return $this->createQueryBuilder("a")
            ->where("a.datePublication > '2020-10-01'")
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Article[]
     */

    public function getPublishedArticles(){
        return $this->createQueryBuilder("art")
            ->where("art.datePublication <= :current_date")
            ->setParameter("current_date", new \DateTime())
            ->getQuery()
            ->getResult();
    }

    /**
     * @param string $userSearch string to search
     * @param string $order posts order
     * @return Article[] search result
     */

    public function SearchArticles($userSearch, $order){
        return $this->createQueryBuilder("a")
            ->where("a.contenu LIKE :current_search")
            ->orWhere("a.title LIKE :current_search")
            ->setParameter("current_search", "%$userSearch%")
            ->orderBy("a.datePublication", "$order")
            ->getQuery()
            ->getResult();
    }
}


