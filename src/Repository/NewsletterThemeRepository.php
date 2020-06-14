<?php

namespace App\Repository;

use App\Entity\NewsletterTheme;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method NewsletterTheme|null find($id, $lockMode = null, $lockVersion = null)
 * @method NewsletterTheme|null findOneBy(array $criteria, array $orderBy = null)
 * @method NewsletterTheme[]    findAll()
 * @method NewsletterTheme[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NewsletterThemeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NewsletterTheme::class);
    }

    // /**
    //  * @return NewsletterTheme[] Returns an array of NewsletterTheme objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?NewsletterTheme
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
