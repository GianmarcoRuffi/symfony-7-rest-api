<?php

namespace App\Repository;

use App\Entity\Bike;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class BikeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bike::class);
    }

    public function findAllBikes()
    {
        return $this->createQueryBuilder('b')
            ->getQuery()
            ->getResult();
    }

    public function findByColor($color)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.Color = :color')
            ->setParameter('color', $color)
            ->getQuery()
            ->getResult();
    }

    public function findByBrand($brand)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.Brand = :brand')
            ->setParameter('brand', $brand)
            ->getQuery()
            ->getResult();
    }


}