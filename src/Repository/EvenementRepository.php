<?php

namespace App\Repository;

use App\Entity\Evenement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Evenement>
 *
 * @method Evenement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Evenement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Evenement[]    findAll()
 * @method Evenement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EvenementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Evenement::class);
    }

    public function save(Evenement $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Evenement $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Evenement[] Returns an array of Evenement objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Evenement
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
// trier par nom d'utilisateur
public function sortBynomev() {
    return $this->createQueryBuilder('e')
        ->orderBy('e.nomev', 'ASC')
        ->getQuery()
        ->getResult();
}

// trier par nombre de votes
public function sortBydatedev() {
    return $this->createQueryBuilder('e')
        ->orderBy('e.datedev', 'DESC')
        ->getQuery()
        ->getResult();
}
public function sortBylocalisation() {
    return $this->createQueryBuilder('e')
        ->orderBy('e.localisation', 'DESC')
        ->getQuery()
        ->getResult();
}



// rechercher par nom d'utilisateur
public function findBynomev($nomev) {
    return $this->createQueryBuilder('e')
        ->where('e.nomev LIKE :nomev')
        ->setParameter('nomev', '%'.$nomev.'%')
        ->getQuery()
        ->getResult();
}

// rechercher par nombre de votes
public function findBydatedev($datedev) {
    return $this->createQueryBuilder('e')
        ->where('e.datedev = :datedev')
        ->setParameter('datedev', $datedev)
        ->getQuery()
        ->getResult();
}

public function findBylocalisation($localisation) {
    return $this->createQueryBuilder('e')
        ->where('e.localisation = :localisation')
        ->setParameter('localisation', $localisation)
        ->getQuery()
        ->getResult();
}
public function advancedSearch($nomev, $datedev,$localisation,$idev)
{
    $qb = $this->createQueryBuilder('e');

    if ($nomev) {
        $qb->andWhere('e.nomev LIKE :nomev')
            ->setParameter('nomev', '%'.$nomev.'%');
    }

    if ($datedev) {
        $qb->andWhere('e.datedev = :datedev')
            ->setParameter('datedev', $datedev);
    }
    if ($localisation) {
        $qb->andWhere('e.localisation = :localisation')
            ->setParameter('localisation', $localisation);
    }
    if ($idev) {
        $qb->andWhere('e.idev = :idev')
            ->setParameter('idev', $idev);
    }


    return $qb->getQuery()->getResult();
}


}
