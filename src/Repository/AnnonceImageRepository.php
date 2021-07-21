<?php

namespace App\Repository;

use App\Entity\AnnonceImage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AnnonceImage|null find($id, $lockMode = null, $lockVersion = null)
 * @method AnnonceImage|null findOneBy(array $criteria, array $orderBy = null)
 * @method AnnonceImage[]    findAll()
 * @method AnnonceImage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnnonceImageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AnnonceImage::class);
    }

    // /**
    //  * @return AnnonceImage[] Returns an array of AnnonceImage objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AnnonceImage
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
