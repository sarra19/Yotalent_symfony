<?php

namespace App\Repository;

use App\Entity\Espacetalent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Espacetalent>
 *
 * @method Espacetalent|null find($id, $lockMode = null, $lockVersion = null)
 * @method Espacetalent|null findOneBy(array $criteria, array $orderBy = null)
 * @method Espacetalent[]    findAll()
 * @method Espacetalent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EspaceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Espacetalent::class);
    }

    public function save(Espacetalent $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Espacetalent $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
// trier par nom d'utilisateur
public function sortByUsername() {
    return $this->createQueryBuilder('e')
        ->orderBy('e.username', 'ASC')
        ->getQuery()
        ->getResult();
}

// trier par nombre de votes
public function sortByNbVotes() {
    return $this->createQueryBuilder('e')
        ->orderBy('e.nbvotes', 'DESC')
        ->getQuery()
        ->getResult();
}

// rechercher par nom d'utilisateur
public function findByUsername($username) {
    return $this->createQueryBuilder('e')
        ->where('e.username LIKE :username')
        ->setParameter('username', '%'.$username.'%')
        ->getQuery()
        ->getResult();
}

// rechercher par nombre de votes
public function findByNbVotes($nbvotes) {
    return $this->createQueryBuilder('e')
        ->where('e.nbvotes = :nbvotes')
        ->setParameter('nbvotes', $nbvotes)
        ->getQuery()
        ->getResult();
}
public function searchAdvanced($username, $nbvotes, $idest) {
    $query = $this->createQueryBuilder('p')
        ->where('p.username LIKE :username OR p.nbvotes LIKE :nbvotes OR p.idest LIKE :idest')
        ->setParameter('username', '%'.$username.'%')
        ->setParameter('nbvotes', '%'.$nbvotes.'%')
        ->setParameter('idest', '%'.$idest.'%')
        ->getQuery();

    return $query->getResult();
}
public function countByVoteIntervals()
{
    $qb = $this->createQueryBuilder('e');

    $interval1 = $qb->expr()->andX(
        $qb->expr()->gte('e.nbvotes', 0),
        $qb->expr()->lte('e.nbvotes', 10)
    );

    $interval2 = $qb->expr()->andX(
        $qb->expr()->gt('e.nbvotes', 10),
        $qb->expr()->lte('e.nbvotes', 20)
    );

    $interval3 = $qb->expr()->andX(
        $qb->expr()->gt('e.nbvotes', 20),
        $qb->expr()->lte('e.nbvotes', 50)
    );

    $entitiesInterval1 = $qb->select('COUNT(e) as count')
        ->andWhere($interval1)
        ->getQuery()
        ->getSingleScalarResult();

    $entitiesInterval2 = $qb->select('COUNT(e) as count')
        ->andWhere($interval2)
        ->getQuery()
        ->getSingleScalarResult();

    $entitiesInterval3 = $qb->select('COUNT(e) as count')
        ->andWhere($interval3)
        ->getQuery()
        ->getSingleScalarResult();

    $total = $entitiesInterval1 + $entitiesInterval2 + $entitiesInterval3;

    $percentages = [        'interval1' => ($total > 0) ? round(($entitiesInterval1 / $total) * 100, 2) : 0,        'interval2' => ($total > 0) ? round(($entitiesInterval2 / $total) * 100, 2) : 0,        'interval3' => ($total > 0) ? round(($entitiesInterval3 / $total) * 100, 2) : 0,    ];

    return $percentages;
}

}