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
public function searchAdvanced($username, $nbVotes, $idest) {
    $query = $this->createQueryBuilder('p')
        ->where('p.username LIKE :username OR p.nbVotes LIKE :nbVotes OR p.idest LIKE :idest')
        ->setParameter('username', '%'.$username.'%')
        ->setParameter('nbVotes', '%'.$nbVotes.'%')
        ->setParameter('idest', '%'.$idest.'%')
        ->getQuery();

    return $query->getResult();
}


}