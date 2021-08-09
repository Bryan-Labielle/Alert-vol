<?php

namespace App\Repository;

use App\Entity\Annonce;
use App\Service\SearchData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @method Annonce|null find($id, $lockMode = null, $lockVersion = null)
 * @method Annonce|null findOneBy(array $criteria, array $orderBy = null)
 * @method Annonce[]    findAll()
 * @method Annonce[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnnonceRepository extends ServiceEntityRepository
{
    /**
     * @var PaginatorInterface
     */
    private PaginatorInterface $paginator;

    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, Annonce::class);
        $this->paginator = $paginator;
    }

    public function findLastAnnonces(): ?array
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.status = 1')
            ->orderBy('e.publishedAt', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult();
    }

    /**
     * Récupère les produits en lien avec une recherche
     * @param SearchData $search
     * @return PaginationInterface
     */
    public function findSearch(SearchData $search): PaginationInterface
    {
        $query = $this
            ->createQueryBuilder('a')
            ->select('c', 'a')
            ->join('a.category', 'c')
            ->andWhere('a.status = 1')
            ->orderBy('a.stolenAt', 'DESC');

        if (!empty($search->categories)) {
            $query = $query
                ->andWhere('c.id IN (:category)')
                ->setParameter('category', $search->categories);
        }

        if (!empty($search->placeSearch)) {
            $query = $query
                ->andWhere('a.city LIKE :queryPlace')
                ->setParameter('queryPlace', $search->placeSearch);
        }

        if (!empty($search->search)) {
            $query = $query
                ->andWhere('a.title LIKE :search')
                ->setParameter('search', '%' . $search->search . '%');
        }
        if (!empty($search->dateSearch)) {
            $query = $query
            ->andWhere('a.stolenAt > :queryDate')
                ->setParameter('queryDate', $search->dateSearch);
        }

        $query = $query
            ->orderBy('a.stolenAt', 'DESC')
//            ->setMaxResults(25)
            ->getQuery();

            return $this->paginator->paginate(
                $query,
                $search->page,
                9
            );
    }

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
