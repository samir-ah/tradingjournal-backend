<?php

namespace App\Repository;

use App\Entity\TradeLike;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TradeLike|null find($id, $lockMode = null, $lockVersion = null)
 * @method TradeLike|null findOneBy(array $criteria, array $orderBy = null)
 * @method TradeLike[]    findAll()
 * @method TradeLike[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TradeLikeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TradeLike::class);
    }

     /**
      * @return int Returns the number of likes for a trade
      */
    public function countLikesByTrade(int $tradeId): int
    {

        try {
            return $this->getEntityManager()->createQueryBuilder()
                ->select('count(t.trade)')
                ->from($this->_entityName, 't')
                ->andWhere('t.trade = :trade_id')
                ->setParameter('trade_id', $tradeId)
                ->getQuery()
                ->getSingleScalarResult();
        } catch (NoResultException | NonUniqueResultException $e) {
            return -1;
        }
    }

/*
    public function findOneBySomeField($value): ?TradeLike
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
