<?php

namespace App\Repository;

use App\Entity\Buttons;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Buttons|null find($id, $lockMode = null, $lockVersion = null)
 * @method Buttons|null findOneBy(array $criteria, array $orderBy = null)
 * @method Buttons[]    findAll()
 * @method Buttons[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ButtonsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Buttons::class);
    }

    // /**
    //  * @return Buttons[] Returns an array of Buttons objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Buttons
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
