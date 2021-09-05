<?php

namespace App\Repository;

use App\Entity\TradeImage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TradeImage|null find($id, $lockMode = null, $lockVersion = null)
 * @method TradeImage|null findOneBy(array $criteria, array $orderBy = null)
 * @method TradeImage[]    findAll()
 * @method TradeImage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TradeImageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TradeImage::class);
    }

    // /**
    //  * @return TradeImage[] Returns an array of TradeImage objects
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
    public function findOneBySomeField($value): ?TradeImage
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
