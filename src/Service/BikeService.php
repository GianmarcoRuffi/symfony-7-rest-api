<?php

namespace App\Service;

use App\Entity\Bike;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class BikeService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getAllBikes(): JsonResponse
    {
        try {
            $bikes = $this->entityManager->getRepository(Bike::class)->findAll();

            $data = [];
            foreach ($bikes as $bike) {
                $data[] = [
                    'id' => $bike->getId(),
                    'brand' => $bike->getBrand(),
                    'engine' => [
                        'name' => $bike->getEngine()->getName(),
                        'serial_code' => $bike->getEngine()->getSerialCode(),
                        'manufacturer' => $bike->getEngine()->getManufacturer(),
                        'horsepower' => $bike->getEngine()->getHorsepower(),
                    ],
                    'color' => $bike->getColor(),
                ];
            }

            return new JsonResponse($data);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
