<?php

namespace App\Repository;

use App\Entity\SignalementImage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SignalementImage|null find($id, $lockMode = null, $lockVersion = null)
 * @method SignalementImage|null findOneBy(array $criteria, array $orderBy = null)
 * @method SignalementImage[]    findAll()
 * @method SignalementImage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SignalementImageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SignalementImage::class);
    }

    // /**
    //  * @return SignalementImage[] Returns an array of SignalementImage objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SignalementImage
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
