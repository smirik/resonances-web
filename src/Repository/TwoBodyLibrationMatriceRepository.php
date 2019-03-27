<?php

namespace App\Repository;

use App\Entity\TwoBodyLibrationMatrice;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TwoBodyLibrationMatrice|null find($id, $lockMode = null, $lockVersion = null)
 * @method TwoBodyLibrationMatrice|null findOneBy(array $criteria, array $orderBy = null)
 * @method TwoBodyLibrationMatrice[]    findAll()
 * @method TwoBodyLibrationMatrice[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TwoBodyLibrationMatriceRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TwoBodyLibrationMatrice::class);
    }

}
