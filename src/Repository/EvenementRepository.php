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
public function SortBynomev(){
    return $this->createQueryBuilder('e')//alias bch t3awedh kelmet Evenement 
        ->orderBy('e.nomev','ASC')
        ->getQuery()
        ->getResult()
        ;
}

public function SortBydatedev()
{
    return $this->createQueryBuilder('e')
        ->orderBy('e.datedev','ASC')
        ->getQuery()
        ->getResult()
        ;
}



public function SortByDatefev()
{
    return $this->createQueryBuilder('e')
        ->orderBy('e.datefev','ASC')
        ->getQuery()
        ->getResult()
        ;
}
public function SortBylocalisation()
{
    return $this->createQueryBuilder('e')
        ->orderBy('e.localisation','ASC')
        ->getQuery()
        ->getResult()
        ;
}








public function findBynomev( $nomev)
{
    return $this-> createQueryBuilder('e')
        ->andWhere('e.nomev LIKE :nomev')
        ->setParameter('nomev','%' .$nomev. '%')
        ->getQuery()
        ->execute();
}
public function findBydatedev( $datedev)
{
    return $this-> createQueryBuilder('e')
        ->andWhere('e.datedev LIKE :datedev')
        ->setParameter('datedev','%' .$datedev. '%')
        ->getQuery()
        ->execute();
}
public function findByDatefev( $datefev)
{
    return $this-> createQueryBuilder('e')
        ->andWhere('e.datefev LIKE :datefev')
        ->setParameter('datefev','%' .$datefev. '%')
        ->getQuery()
        ->execute();
}
public function findBylocalisation( $localisation)
{
    return $this-> createQueryBuilder('e')
        ->andWhere('e.localisation LIKE :localisation')
        ->setParameter('localisation','%' .$localisation. '%')
        ->getQuery()
        ->execute();
}


}
