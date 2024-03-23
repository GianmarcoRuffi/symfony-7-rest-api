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
    public function create(Request $request): ?JsonResponse
    {
        $data = [
            'name' => $request->request->get('name'),
            'serial_code' => $request->request->get('serial_code'),
            'horsepower' => $request->request->get('horsepower'),
            'manufacturer' => $request->request->get('manufacturer'),
        ];

        return $this->engineService->createEngine($data);
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
        $data = [
            'name' => $request->request->get('name'),
            'serial_code' => $request->request->get('serial_code'),
            'horsepower' => $request->request->get('horsepower'),
            'manufacturer' => $request->request->get('manufacturer'),
        ];

        try {
            $engine = $this->engineService->updateEngine($serial_code, $data);
        } catch (\RuntimeException $e) {
            return $this->json(['error' => $e->getMessage()], 400);
        }

        if (!$engine) {
            return $this->json('No engine found for serial code: ' . $serial_code, 404);
        }

        $responseData = [
            'id' => $engine->getSerialCode(),
            'name' => $engine->getName(),
            'serial_code' => $engine->getSerialCode(),
            'horsepower' => $engine->getHorsepower(),
            'manufacturer' => $engine->getManufacturer(),
        ];

        return $this->json($responseData);
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
