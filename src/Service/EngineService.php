<?php

namespace App\Service;

use App\Entity\Engine;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class EngineService
{
    private $entityManager;
    private $validator;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        $this->entityManager = $entityManager;
        $this->validator = $validator;
    }

    public function getAllEngines(): JsonResponse
    {
        try {
            $engines = $this->entityManager
                ->getRepository(Engine::class)
                ->findAll();

            $data = [];

            foreach ($engines as $engine) {
                $data[] = [
                    'id' => $engine->getSerialCode(),
                    'name' => $engine->getName(),
                    'serial_code' => $engine->getSerialCode(),
                    'horsepower' => $engine->getHorsepower(),
                    'manufacturer' => $engine->getManufacturer(),
                ];
            }

            return new JsonResponse($data);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
