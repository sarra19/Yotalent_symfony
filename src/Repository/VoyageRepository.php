<?php

namespace App\Repository;

use App\Entity\Voyage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Voyage>
 *
 * @method Voyage|null find($id, $lockMode = null, $lockVersion = null)
 * @method Voyage|null findOneBy(array $criteria, array $orderBy = null)
 * @method Voyage[]    findAll()
 * @method Voyage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VoyageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Voyage::class);
    }

    public function save(Evenement $entity, bool $flush = false): void
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
public function sortByIdVoy() {
    return $this->createQueryBuilder('e')
        ->orderBy('e.idvoy', 'ASC')
        ->getQuery()
        ->getResult();
}

// trier par nombre de votes
public function sortByDateD() {
    return $this->createQueryBuilder('e')
        ->orderBy('e.datedvoy', 'DESC')
        ->getQuery()
        ->getResult();
}
public function sortByDateR() {
    return $this->createQueryBuilder('e')
        ->orderBy('e.datervoy', 'DESC')
        ->getQuery()
        ->getResult();
}

// rechercher par nom d'utilisateur
public function findByIdVoy($idvoy) {
    return $this->createQueryBuilder('e')
        ->where('e.idvoy LIKE :idvoy')
        ->setParameter('idvoy', '%'.$idvoy.'%')
        ->getQuery()
        ->getResult();
}

// rechercher par nombre de votes
public function findByDateD($datedvoy) {
    return $this->createQueryBuilder('e')
        ->where('e.datedvoy = :datedvoy')
        ->setParameter('datedvoy', $datedvoy)
        ->getQuery()
        ->getResult();
}


public function findByDateR($datervoy) {
    return $this->createQueryBuilder('e')
        ->where('e.datervoy = :datervoy')
        ->setParameter('datervoy', $datervoy)
        ->getQuery()
        ->getResult();
}
public function searchAdvanced($idvoy, $datedvoy, $datervoy) {
    $query = $this->createQueryBuilder('p')
        ->where('p.idvoy LIKE :idvoy OR p.datedvoy LIKE :datedvoy OR p.datervoy LIKE :datervoy')
        ->setParameter('idvoy', '%'.$idvoy.'%')
        ->setParameter('datedvoy', '%'.$datedvoy.'%')
        ->setParameter('datervoy', '%'.$datervoy.'%')
        ->getQuery();

    return $query->getResult();
}
public function countdarrive(): array
{
    $qb = $this->createQueryBuilder('d')
        ->select('d.destination as destination, COUNT(DISTINCT d.idvoy) as count')
        ->groupBy('d.destination')
        ->getQuery();

    return $qb->getResult();
}

}