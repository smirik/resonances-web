<?php

namespace App\Repository;

use App\Entity\ProperElement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ProperElement|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProperElement|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProperElement[]    findAll()
 * @method ProperElement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProperElementRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ProperElement::class);
    }

}
