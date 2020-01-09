<?php

namespace App\Repository;

use App\Entity\Livre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Livre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Livre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Livre[]    findAll()
 * @method Livre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LivreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Livre::class);
    }

    // /**
    //  * @return Livre[] Returns an array of Livre objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    
    public function findOneById($id): ?Livre
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    

    public function findAll()
    {
        $qb = $this->createQueryBuilder('livre')
            ->addOrderBy('livre.titre', 'asc');
        $query = $qb->getQuery();
        
        return $query->execute();

    }

    
    public function findBooksByCategorie($id):array
{
    return $this->createQueryBuilder('l')
        ->join('l.souscategorie', 's')
        ->join('s.categorie', 'c')
        ->andWhere('s.categorie = :categorie')
        ->setParameter('categorie', $id)
        ->getQuery()
        ->getResult();

}   

public function findBySousCategorie($id):array
{
    return $this->createQueryBuilder('l')
        ->join('l.souscategorie', 's')
        ->andWhere('l.souscategorie = :souscategorie')
        ->setParameter('souscategorie', $id)
        ->getQuery()
        ->getResult();

}    


public function findBooksByData($data):array
{
    return $this->createQueryBuilder('l')
        ->join('l.auteur', 'a')
        ->join('l.editeur', 'e')
        ->where('l.titre like :data')
        ->orWhere('l.ref like :data')
        ->orWhere('a.nom like :data')
        ->orWhere('e.nom like :data')
        ->setParameter('data', "%" . $data . "%")
        ->getQuery()
        ->getResult();

}   

}
