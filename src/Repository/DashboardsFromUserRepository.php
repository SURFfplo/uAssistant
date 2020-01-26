<?php

namespace App\Repository;

use App\Entity\DashboardsFromUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method DashboardsFromUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method DashboardsFromUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method DashboardsFromUser[]    findAll()
 * @method DashboardsFromUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DashboardsFromUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DashboardsFromUser::class);
    }

    // /**
    //  * @return DashboardsFromUser[] Returns an array of DashboardsFromUser objects
    //  */
    public function findByUserId($user)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.userId = :val')
            ->setParameter('val', $user)
            ->orderBy('d.position', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
 }
