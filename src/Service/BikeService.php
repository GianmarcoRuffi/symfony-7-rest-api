<?php

namespace App\Service;

use App\Entity\Bike;
use App\Entity\Engine;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class BikeService
{
    private $entityManager;
    private $validator;
    private $request;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator, RequestStack $requestStack)
    {
        $this->entityManager = $entityManager;
        $this->validator = $validator;
        $this->request = $requestStack->getCurrentRequest();
    }

    public function getAllBikes(): array
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

            return $data;
        } catch (\Exception $e) {
            throw $e;
        }
    }


    public function createBike(): JsonResponse
    {
        $brand = $this->request->request->get('brand');
        $color = $this->request->request->get('color');
        $engineSerial = $this->request->request->get('engine_serial');

        if ($brand === null || $color === null || $engineSerial === null) {
            return new JsonResponse(['error' => 'Mandatory fields cannot be null.'], 400);
        }

        $engine = $this->entityManager->getRepository(Engine::class)->findOneBy(['SerialCode' => $engineSerial]);

        $bike = new Bike();
        $bike->setBrand($brand);
        $bike->setColor($color);
        $bike->setEngine($engine);

        $errors = $this->validator->validate($bike);

        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }
            return new JsonResponse(['errors' => $errorMessages], 400);
        }

        $this->entityManager->persist($bike);
        $this->entityManager->flush();

        $data = [
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

        return new JsonResponse($data);
    }


    public function getBikeById(int $id): ?array
    {
        $bike = $this->entityManager->getRepository(Bike::class)->find($id);

        if (!$bike) {
            return null;
        }

        $data = [
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

        return $data;
    }


    public function deleteBikeById(int $id): bool
    {
        $bike = $this->entityManager->getRepository(Bike::class)->find($id);

        if (!$bike) {
            return false;
        }

        $this->entityManager->remove($bike);
        $this->entityManager->flush();

        return true;
    }
}
