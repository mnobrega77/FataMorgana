<?php

namespace App\Repository;

use App\Entity\Contient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Contient|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contient|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contient[]    findAll()
 * @method Contient[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contient::class);
    }

    // /**
    //  * @return Contient[] Returns an array of Contient objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Contient
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
