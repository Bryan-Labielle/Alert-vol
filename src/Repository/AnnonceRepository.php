<?php

namespace App\Repository;

use App\Entity\Annonce;
use DateTimeImmutable;
use DateInterval;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Annonce|null find($id, $lockMode = null, $lockVersion = null)
 * @method Annonce|null findOneBy(array $criteria, array $orderBy = null)
 * @method Annonce[]    findAll()
 * @method Annonce[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnnonceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Annonce::class);
    }

    public function findByQuery(?string $query): ?array
    {
        $query = "%$query%";
        return $this->createQueryBuilder('a')
            ->andWhere('a.title LIKE :query')
            ->setParameter('query', $query)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(25)
            ->getQuery()
            ->getResult();
    }

    public function findByDate(?string $queryDate): ?array
    {
        $queryDate = "%$queryDate%";
        return $this->createQueryBuilder('a')
            ->andWhere('a.stolenAt LIKE :queryDate')
            ->setParameter('queryDate', $queryDate)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(25)
            ->getQuery()
            ->getResult();
    }

    public function findByQueryPlace(?string $queryPlace): ?array
    {
        $queryPlace = "%$queryPlace%";
        return $this->createQueryBuilder('a')
            ->andWhere('a.location LIKE :queryPlace')
            ->setParameter('queryPlace', $queryPlace)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(25)
            ->getQuery()
            ->getResult();
    }

    public function findLastAnnonces(): ?array
    {
        return $this->createQueryBuilder('e')

            ->orderBy('e.publishedAt', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult();
    }
    // /**
    //  * @return Annonce[] Returns an array of Annonce objects
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
    public function findOneBySomeField($value): ?Annonce
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
