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
public function findByNbVotes($nbVotes) {
    return $this->createQueryBuilder('e')
        ->where('e.nbvotes = :nbvotes')
        ->setParameter('nbvotes', $nbVotes)
        ->getQuery()
        ->getResult();
}
public function advancedSearch($username, $nbVotes,$idest)
{
    $qb = $this->createQueryBuilder('e');

    if ($username) {
        $qb->andWhere('e.username LIKE :username')
            ->setParameter('username', '%'.$username.'%');
    }

    if ($nbVotes) {
        $qb->andWhere('e.nbvotes = :nbvotes')
            ->setParameter('nbvotes', $nbVotes);
    }
    if ($idest) {
        $qb->andWhere('e.idest = :idest')
            ->setParameter('idest', $idest);
    }


    return $qb->getQuery()->getResult();
}


}