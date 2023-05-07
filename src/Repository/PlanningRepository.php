<?php

namespace App\Repository;

use App\Entity\Planning;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Planning>
 *
 * @method Planning|null find($id, $lockMode = null, $lockVersion = null)
 * @method Planning|null findOneBy(array $criteria, array $orderBy = null)
 * @method Planning[]    findAll()
 * @method Planning[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlanningRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Planning::class);
    }

    public function save(Planning $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Planning $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Planning[] Returns an array of Planning objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Planning
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

// trier par nom d'utilisateur
public function sortByhour() {
    return $this->createQueryBuilder('e')
        ->orderBy('e.hour', 'ASC')
        ->getQuery()
        ->getResult();
}

// trier par nombre de votes
public function sortBynomactivite() {
    return $this->createQueryBuilder('e')
        ->orderBy('e.nomactivite', 'DESC')
        ->getQuery()
        ->getResult();
}
public function sortBydatepl() {
    return $this->createQueryBuilder('e')
        ->orderBy('e.datepl', 'DESC')
        ->getQuery()
        ->getResult();
}



// rechercher par nom d'utilisateur
public function findByhour($hour) {
    return $this->createQueryBuilder('e')
        ->where('e.hour LIKE :hour')
        ->setParameter('hour', '%'.$hour.'%')
        ->getQuery()
        ->getResult();
}

// rechercher par nombre de votes
public function findBynomactivite($nomactivite) {
    return $this->createQueryBuilder('e')
        ->where('e.nomactivite = :nomactivite')
        ->setParameter('nomactivite', $nomactivite)
        ->getQuery()
        ->getResult();
}

public function findBydatepl($datepl) {
    return $this->createQueryBuilder('e')
        ->where('e.datepl = :datepl')
        ->setParameter('datepl', $datepl)
        ->getQuery()
        ->getResult();
}
public function advancedSearch($hour, $nomactivite,$datepl,$idp)
{
    $qb = $this->createQueryBuilder('e');

    if ($hour) {
        $qb->andWhere('e.hour LIKE :hour')
            ->setParameter('hour', '%'.$hour.'%');
    }

    if ($nomactivite) {
        $qb->andWhere('e.nomactivite = :nomactivite')
            ->setParameter('nomactivite', $nomactivite);
    }
    if ($datepl) {
        $qb->andWhere('e.datepl = :datepl')
            ->setParameter('datepl', $datepl);
    }
    if ($idp) {
        $qb->andWhere('e.idp = :idp')
            ->setParameter('idp', $idp);
    }


    return $qb->getQuery()->getResult();
}

}








