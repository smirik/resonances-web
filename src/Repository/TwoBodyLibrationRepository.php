<?php

namespace App\Repository;

use App\Entity\TwoBodyLibration;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TwoBodyLibration|null find($id, $lockMode = null, $lockVersion = null)
 * @method TwoBodyLibration|null findOneBy(array $criteria, array $orderBy = null)
 * @method TwoBodyLibration[]    findAll()
 * @method TwoBodyLibration[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TwoBodyLibrationRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TwoBodyLibration::class);
    }

    public function getLibrationsStats()
    {
        $query = $this->createQueryBuilder('l')
            ->select(['l.planet1', 'l.m1', 'l.m', 'l.p', 'l.properSemiaxis', 'count(l.m1) as num'])
            ->groupBy('l.planet1')
            ->addGroupBy('l.m1')
            ->addGroupBy('l.m')
            ->addGroupBy('l.p')
            ->orderBy('num', 'DESC')
            ->setMaxResults(100)
            ->getQuery()
        ;

        return $query->getResult();
    }

    private function getLibrationsQuery(array $data, array $select = [])
    {
        $query = $this->createQueryBuilder('l');

        if (count($select) > 0) {
            $query = $query->select($select);
        }

        $query
            ->where('l.properSemiaxis >= :amin')
            ->andWhere('l.properSemiaxis <= :amax')
            ->setParameter('amin', $data['amin'])
            ->setParameter('amax', $data['amax'])
        ;

        if ($data['planet1'] != 'all') {
            $query = $query
                ->andWhere('l.planet1 = :planet1')
                ->setParameter('planet1', $data['planet1'])
            ;
        }

        $query = $query->getQuery();
        return $query;
    }

    public function getLibrations(array $data)
    {
        $query = $this->getLibrationsQuery($data);
        return $query->getResult();
    }

    public function getLibrationsAsScalarResult(array $data)
    {
        $query = $this->getLibrationsQuery($data, ['l.number', 'l.pure', 'l.planet1', 'l.m1', 'l.m', 'l.p1', 'l.p']);
        return $query->getScalarResult();
    }

    public function getLibrationsForPlanets(string $planet1) : array
    {
        $query = $this->createQueryBuilder('l')
            ->select(['l.planet1', 'l.m1', 'l.m', 'COUNT(l.number) AS num', 'AVG(l.properSemiaxis) AS avg_semiaxis'])
            ->groupBy('l.planet1')
            ->AddGroupBy('l.m1')
            ->AddGroupBy('l.m')
            ->having('l.planet1 = :planet1')
            ->setParameter('planet1', $planet1)
            ->orderBy('l.m1', 'ASC')
            ->addOrderBy('l.m', 'ASC')
            ->getQuery()
        ;

        $resonances = $query->execute();
        return $resonances;
    }

    public function getAsteroidsForResonance(string $planet1, int $m1, int $m)
    {
        $query = $this->createQueryBuilder('l')
            ->where('l.planet1 = :planet1')
            ->andWhere('l.m1 = :m1')
            ->andWhere('l.m = :m')
            ->setParameter('planet1', $planet1)
            ->setParameter('m1', $m1)
            ->setParameter('m', $m)
            ->orderBy('l.number', 'ASC')
            ->getQuery()
        ;

        $resonances = $query->execute();
        return $resonances;
    }

}
