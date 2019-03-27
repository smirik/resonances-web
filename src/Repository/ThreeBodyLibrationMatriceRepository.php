<?php

namespace App\Repository;

use App\Entity\ThreeBodyLibrationMatrice;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ThreeBodyLibrationMatrice|null find($id, $lockMode = null, $lockVersion = null)
 * @method ThreeBodyLibrationMatrice|null findOneBy(array $criteria, array $orderBy = null)
 * @method ThreeBodyLibrationMatrice[]    findAll()
 * @method ThreeBodyLibrationMatrice[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ThreeBodyLibrationMatriceRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ThreeBodyLibrationMatrice::class);
    }

}
