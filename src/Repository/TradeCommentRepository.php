<?php

namespace App\Repository;

use App\Entity\TradeComment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TradeComment|null find($id, $lockMode = null, $lockVersion = null)
 * @method TradeComment|null findOneBy(array $criteria, array $orderBy = null)
 * @method TradeComment[]    findAll()
 * @method TradeComment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TradeCommentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TradeComment::class);
    }

    // /**
    //  * @return TradeComment[] Returns an array of TradeComment objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TradeComment
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
