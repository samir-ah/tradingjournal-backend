<?php

namespace App\Repository;

use App\Entity\Trade;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Trade|null find($id, $lockMode = null, $lockVersion = null)
 * @method Trade|null findOneBy(array $criteria, array $orderBy = null)
 * @method Trade[]    findAll()
 * @method Trade[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TradeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Trade::class);
    }

    // /**
    //  * @return Trade[] Returns an array of Trade objects
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


    public function findPerformanceGroupByMonth(int $userId, int $lastMonths): array
    {
        return $this->createQueryBuilder('t')
            ->select('YEAR(t.startAt) as year, MONTH(t.startAt) as month', 'SUM(t.finalRatio) AS ratio')
            ->andWhere('t.author = :authorId')
            ->andWhere("t.startAt > DATESUB(CURRENT_DATE(), :lastMonths, 'MONTH')")
            ->groupBy("month")
            ->setParameter('authorId', $userId)
            ->setParameter('lastMonths', $lastMonths)
            ->getQuery()
            ->getResult();
    }

    public function findPerformance(int $userId, int $lastMonths): array
    {
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult("cumulative_sum", "cumulative_sum");
        $sql = 'SELECT SUM(final_ratio) OVER(ORDER BY id) AS cumulative_sum' .
            ' FROM trade' .
            ' WHERE author_id = :authorId' .
            ' AND start_at > DATE_SUB(now(), INTERVAL :lastMonths MONTH)';
        return $this->getEntityManager()->createNativeQuery($sql, $rsm)
            ->setParameter('authorId', $userId)
            ->setParameter('lastMonths', $lastMonths)
            ->getScalarResult();

    }

    /**
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findTotalPerformanceSum(int $userId): array
    {
        return $this->createQueryBuilder('t')
            ->select('SUM(t.finalRatio) AS total')
            ->andWhere('t.author = :authorId')
            ->setParameter('authorId', $userId)
            ->getQuery()
            ->getOneOrNullResult();
    }

}
