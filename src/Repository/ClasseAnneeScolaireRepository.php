<?php

namespace App\Repository;

use App\Entity\ClasseAnneeScolaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ClasseAnneeScolaire>
 */
class ClasseAnneeScolaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ClasseAnneeScolaire::class);
    }

    public function findActiveClasses()
    {
        //->innerJoin('u.Phonenumbers', 'p', Expr\Join::WITH, 'p.is_primary = 1');
        return $this->createQueryBuilder('t')
        ->innerJoin('t.anneeScolaire', 'c')
        ->andWhere('c.active = :actif')
        ->setParameter('actif', true)
        ->getQuery()
        ->getResult();
    }



    //    /**
    //     * @return ClasseAnneeScolaire[] Returns an array of ClasseAnneeScolaire objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?ClasseAnneeScolaire
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
