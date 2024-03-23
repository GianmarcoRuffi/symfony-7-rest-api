<?php

namespace App\Repository;

use App\Entity\Engine;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class EngineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Engine::class);
    }

    public function findAllEngines(): array
    {
        return $this->createQueryBuilder('e')
            ->getQuery()
            ->getResult();
    }

    public function findOneByName(string $name): ?Engine
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.name = :name')
            ->setParameter('name', $name)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findOneBySerialCode(string $serialCode): ?Engine
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.serialCode = :serialCode')
            ->setParameter('serialCode', $serialCode)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findAllByManufacturer(string $manufacturer): array
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.manufacturer = :manufacturer')
            ->setParameter('manufacturer', $manufacturer)
            ->getQuery()
            ->getResult();
    }

    public function findAllWithHorsepowerGreaterThan(int $horsepower): array
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.horsepower > :horsepower')
            ->setParameter('horsepower', $horsepower)
            ->getQuery()
            ->getResult();
    }
}
