<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Engine;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Service\EngineService;

#[Route('/api', name: 'api_')]
class EngineController extends AbstractController
{
    private $engineService;

    public function __construct(EngineService $engineService)
    {
        $this->engineService = $engineService;
    }



    #[Route('/engines', name: 'engine_index', methods: ['GET'])]
    public function index(): JsonResponse
    {
        return $this->engineService->getAllEngines();
    }



    #[Route('/engines', name: 'engine_create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!$data) {
            return $this->json(['error' => 'Mandatory fields cannot be null.'], 400);
        }

        $engine = $this->engineService->createEngine($data);

        if (!$engine) {
            return $this->json(['error' => 'Mandatory fields cannot be null or validation failed.'], 400);
        }

        return $this->json([
            'id' => $engine->getSerialCode(),
            'name' => $engine->getName(),
            'serial_code' => $engine->getSerialCode(),
            'horsepower' => $engine->getHorsepower(),
            'manufacturer' => $engine->getManufacturer(),
        ]);
    }

    #[Route('/engines/{serial_code}', name: 'engine_show', methods: ['GET'])]
    public function show(string $serial_code): JsonResponse
    {
        $engine = $this->engineService->getEngineBySerialCode($serial_code);

        if (!$engine) {
            return $this->json('No engine found for serial code: ' . $serial_code, 404);
        }

        return $this->json([
            'id' => $engine->getSerialCode(),
            'name' => $engine->getName(),
            'serial_code' => $engine->getSerialCode(),
            'horsepower' => $engine->getHorsepower(),
            'manufacturer' => $engine->getManufacturer(),
        ]);
    }

    #[Route('/engines/{serial_code}', name: 'engine_update', methods: ['PUT', 'PATCH'])]
    public function update(Request $request, string $serial_code): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!$data) {
            return $this->json(['error' => 'Invalid JSON data.'], 400);
        }

        $engine = $this->engineService->updateEngine($serial_code, $data);

        if (!$engine) {
            return $this->json('No engine found for serial code: ' . $serial_code, 404);
        }

        return $this->json([
            'id' => $engine->getSerialCode(),
            'name' => $engine->getName(),
            'serial_code' => $engine->getSerialCode(),
            'horsepower' => $engine->getHorsepower(),
            'manufacturer' => $engine->getManufacturer(),
        ]);
    }

    #[Route('/engines/{serial_code}', name: 'engine_delete', methods: ['DELETE'])]
    public function delete(string $serial_code): JsonResponse
    {
        $success = $this->engineService->deleteEngine($serial_code);

        if (!$success) {
            return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
        }

        return $this->json('The engine with serial code ' . $serial_code . ' has been successfully deleted');
    }
}
