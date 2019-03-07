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
