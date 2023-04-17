<?php

namespace App\Repository;

use App\Entity\Remboursement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Remboursement>
 *
 * @method Remboursement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Remboursement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Remboursement[]    findAll()
 * @method Remboursement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RemboursementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Remboursement::class);
    }

    public function save(Remboursement $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Remboursement $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Remboursement[] Returns an array of Remboursement objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Remboursement
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
// trier par decission
public function sortBydc() {
    return $this->createQueryBuilder('e')
        ->orderBy('e.dc', 'ASC')
        ->getQuery()
        ->getResult();
}
// trier par id ticket
public function sortByidt() {
    return $this->createQueryBuilder('e')
        ->orderBy('e.idt', 'DESC')
        ->getQuery()
        ->getResult();
}

// trier par id user
public function sortByidu() {
    return $this->createQueryBuilder('e')
        ->orderBy('e.idu', 'DESC')
        ->getQuery()
        ->getResult();
}

// trier par id remboursement
public function sortByidrem() {
    return $this->createQueryBuilder('e')
        ->orderBy('e.idrem', 'DESC')
        ->getQuery()
        ->getResult();
}


// rechercher par id remboursement
public function findByidt($idt) {
    return $this->createQueryBuilder('e')
        ->where('e.idt = :idt')
        ->setParameter('idt', $idu)
        ->getQuery()
        ->getResult();
}

public function advancedSearch($dc, $idu,$idt,$idrem)
{
    $qb = $this->createQueryBuilder('e');

    if ($dc) {
        $qb->andWhere('e.dc LIKE :dc')
            ->setParameter('dc', '%'.$dc.'%');
    }

    if ($idu) {
        $qb->andWhere('e.idu = :idu')
            ->setParameter('idu', $idu);
    }
    if ($idt) {
        $qb->andWhere('e.idt = :idt')
            ->setParameter('idt', $idt);
    }
   
    if ($idrem) {
        $qb->andWhere('e.idrem = :idrem')
            ->setParameter('idrem', $idrem);
    }


    return $qb->getQuery()->getResult();
}






}
