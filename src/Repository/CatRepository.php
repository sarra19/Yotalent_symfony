<?php

namespace App\Repository;

use App\Entity\Categorie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Categorie>
 *
 * @method Categorie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Categorie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Categorie[]    findAll()
 * @method Categorie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Categorie::class);
    }

    public function save(Categorie $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Categorie $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


// trier par nombre de votes
public function sortByNomCat() {
    return $this->createQueryBuilder('e')
        ->orderBy('e.nomcat', 'ASC')
        ->getQuery()
        ->getResult();
}

public function sortByIdCat() {
    return $this->createQueryBuilder('e')
        ->orderBy('e.idcat', 'ASC')
        ->getQuery()
        ->getResult();
}


public function searchAdvanced($idcat, $nomcat) {
    $query = $this->createQueryBuilder('p')
        ->where('p.idcat LIKE :idcat OR p.nomcat LIKE :nomcat')
        ->setParameter('idcat', '%'.$idcat.'%')
        ->setParameter('nomcat', '%'.$nomcat.'%')
        ->getQuery();

    return $query->getResult();
}



}