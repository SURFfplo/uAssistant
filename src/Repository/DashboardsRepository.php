<?php

namespace App\Repository;

use App\Entity\Dashboards;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Dashboards|null find($id, $lockMode = null, $lockVersion = null)
 * @method Dashboards|null findOneBy(array $criteria, array $orderBy = null)
 * @method Dashboards[]    findAll()
 * @method Dashboards[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DashboardsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Dashboards::class);
    }

    // /**
    //  * @return Dashboards[] Returns an array of Dashboards objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Dashboards
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
