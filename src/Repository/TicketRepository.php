<?php

namespace App\Repository;

use App\Entity\Ticket;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


/**
 * @extends ServiceEntityRepository<Ticket>
 *
 * @method Ticket|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ticket|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ticket[]    findAll()
 * @method Ticket[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TicketRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ticket::class);
    }

    public function save(Ticket $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Ticket $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Ticket[] Returns an array of Ticket objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Ticket
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
// trier par prix ticket
public function sortByprixt() {
    return $this->createQueryBuilder('e')
        ->orderBy('e.prixt', 'ASC')
        ->getQuery()
        ->getResult();
}
// trier par etat
public function sortByetat() {
    return $this->createQueryBuilder('e')
        ->orderBy('e.etat', 'ASC')
        ->getQuery()
        ->getResult();
}
// trier par id ticket
public function sortByidt() {
    return $this->createQueryBuilder('e')
        ->orderBy('e.idt', 'ASC')
        ->getQuery()
        ->getResult();
}


// rechercher par prix ticket
public function findByprixt($prixt) {
    return $this->createQueryBuilder('e')
        ->where('e.prixt LIKE :prixt')
        ->setParameter('prixt', '%'.$prixt.'%')
        ->getQuery()
        ->getResult();
}

// rechercher par etat
public function findByetat($etat) {
    return $this->createQueryBuilder('e')
        ->where('e.etat = :etat')
        ->setParameter('etat', $etat)
        ->getQuery()
        ->getResult();
}
public function advancedSearch($prixt, $nomev,$etat,$idt)
{
    $qb = $this->createQueryBuilder('e');

    if ($prixt) {
        $qb->andWhere('e.prixt LIKE :prixt')
            ->setParameter('prixt', '%'.$prixt.'%');
    }

    if ($nomev) {
        $qb->andWhere('e.nomev = :nomev')
            ->setParameter('nomev', $nomev);
    }
    if ($etat) {
        $qb->andWhere('e.etat = :etat')
            ->setParameter('etat', $etat);
    }
    if ($idt) {
        $qb->andWhere('e.idt = :idt')
            ->setParameter('idt', $idt);
    }


    return $qb->getQuery()->getResult();
}


}
