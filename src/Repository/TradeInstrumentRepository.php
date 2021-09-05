<?php

namespace App\Repository;

use App\Entity\TradeInstrument;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TradeInstrument|null find($id, $lockMode = null, $lockVersion = null)
 * @method TradeInstrument|null findOneBy(array $criteria, array $orderBy = null)
 * @method TradeInstrument[]    findAll()
 * @method TradeInstrument[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TradeInstrumentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TradeInstrument::class);
    }

    // /**
    //  * @return TradeInstrument[] Returns an array of TradeInstrument objects
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
    public function findOneBySomeField($value): ?TradeInstrument
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
