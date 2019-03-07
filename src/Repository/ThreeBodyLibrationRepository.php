<?php

namespace App\Repository;

use App\Entity\ThreeBodyLibration;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ThreeBodyLibration|null find($id, $lockMode = null, $lockVersion = null)
 * @method ThreeBodyLibration|null findOneBy(array $criteria, array $orderBy = null)
 * @method ThreeBodyLibration[]    findAll()
 * @method ThreeBodyLibration[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ThreeBodyLibrationRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ThreeBodyLibration::class);
    }

    public function find100()
    {
        $query = $this->createQueryBuilder('l')
            ->setMaxResults(100)
            ->getQuery();

        return $query->getResult();
    }

    // SELECT planet1, planet2, m1,m2,m,p, proper_semiaxis, COUNT(*) as num
    // FROM three_body_librations GROUP BY planet1, planet2, m1,m2,m,p HAVING proper_semiaxis >= 3.1 AND proper_semiaxis <= 3.2 ORDER BY num DESC LIMIT 100;

    public function getLibrationsStats()
    {
        $query = $this->createQueryBuilder('l')
            ->select(['l.planet1', 'l.planet2', 'l.m1', 'l.m2', 'l.m', 'l.p', 'l.properSemiaxis', 'count(l.m1) as num'])
            ->groupBy('l.planet1')
            ->addGroupBy('l.planet2')
            ->addGroupBy('l.m1')
            ->addGroupBy('l.m2')
            ->addGroupBy('l.m')
            ->addGroupBy('l.p')
            ->orderBy('num', 'DESC')
            ->setMaxResults(100)
            ->getQuery()
        ;

        return $query->getResult();
    }

    public function getLibrations(float $aMin, float $aMax)
    {
        $query = $this->createQueryBuilder('l')
            ->where('l.properSemiaxis >= :amin')
            ->andWhere('l.properSemiaxis <= :amax')
            ->setParameter('amin', $aMin)
            ->setParameter('amax', $aMax)
            ->getQuery()
        ;

        return $query->getResult();
    }
    // /**
    //  * @return Test[] Returns an array of Test objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Test
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
