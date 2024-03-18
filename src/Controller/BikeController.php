<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Bike;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Validation;
use Symfony\Component\HttpFoundation\Response;


#[Route('/api', name: 'api_')]
class BikeController extends AbstractController
{
    #[Route('/bikes', name: 'bike_index', methods: ['get'])]
    public function index(EntityManagerInterface $entityManager): JsonResponse
    {
        try {
            $products = $entityManager
                ->getRepository(Bike::class)
                ->findAll();

            if ($products === null) {
                throw new \RuntimeException('Found null pointer reference when trying to retrieve bikes.');
            }

            $data = [];

            foreach ($products as $product) {
                if ($product === null) {
                    throw new \RuntimeException('Found null pointer reference when trying to retrieve bike details.');
                }

                $data[] = [
                    'id' => $product->getId(),
                    'brand' => $product->getBrand(),
                    'engine_size' => $product->getEngineSize(),
                    'color' => $product->getColor(),
                ];
            }

            return $this->json($data);
        } catch (\Exception $e) {
            return $this->json(['error' => $e->getMessage()], 500);
        }
    }

    #[Route('/bikes', name: 'bike_create', methods: ['post'])]
    public function create(EntityManagerInterface $entityManager, Request $request, ValidatorInterface $validator): JsonResponse
    {

        $brand = $request->request->get('brand');
        $engineSize = $request->request->get('engine_size');
        $color = $request->request->get('color');

        $bike = new Bike();
        $bike->setBrand($brand);
        $bike->setEngineSize((int)$engineSize);
        $bike->setColor($color);

        $errors = $validator->validate($bike);

        if (count($errors) > 0) {

            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }
            return $this->json(['errors' => $errorMessages], 400);
        }

        $entityManager->persist($bike);
        $entityManager->flush();

        $data =  [
            'id' => $bike->getId(),
            'brand' => $bike->getBrand(),
            'engine_size' => $bike->getEngineSize(),
            'color' => $bike->getColor(),
        ];

        return $this->json($data);
    }


    #[Route('/bikes/{id}', name: 'bike_show', methods: ['get'])]
    public function show(EntityManagerInterface $entityManager, int $id): JsonResponse
    {
        $bike = $entityManager->getRepository(Bike::class)->find($id);

        if (!$bike) {

            return $this->json('No bike found for id: ' . $id, 404);
        }

        $data =  [
            'id' => $bike->getId(),
            'brand' => $bike->getBrand(),
            'engine_size' => $bike->getEngineSize(),
            'color' => $bike->getColor(),
        ];

        return $this->json($data);
    }


#[Route('/bikes/{id}', name: 'bike_update', methods: ['put', 'patch'])]
public function update(EntityManagerInterface $entityManager, Request $request, ValidatorInterface $validator, int $id): JsonResponse
{
    $bike = $entityManager->getRepository(Bike::class)->find($id);

    if (!$bike) {
        return $this->json('No bike found for id: ' . $id, 404);
    }

    $brand = $request->request->get('brand');
    $engineSize = $request->request->get('engine_size');
    $color = $request->request->get('color');

    if ($brand !== null) {
        $bike->setBrand($brand);
    }

    if ($engineSize !== null) {
        $bike->setEngineSize((int)$engineSize);
    }

    if ($color !== null) {
        $bike->setColor($color);
    }

    $errors = $validator->validate($bike);

    if (count($errors) > 0) {
        $errorMessages = [];
        foreach ($errors as $error) {
            $errorMessages[] = $error->getMessage();
        }
        return $this->json(['errors' => $errorMessages], 400);
    }

    $entityManager->flush();

    $data =  [
        'id' => $bike->getId(),
        'brand' => $bike->getBrand(),
        'engine_size' => $bike->getEngineSize(),
        'color' => $bike->getColor(),
    ];

    return $this->json($data);
}


    #[Route('/bikes/{id}', name: 'bike_delete', methods: ['delete'])]
    public function delete(EntityManagerInterface $entityManager, int $id): JsonResponse
    {
        $bike = $entityManager->getRepository(Bike::class)->find($id);

        if (!$bike) {
            return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
        }
        $brand = $bike->getBrand();
        $entityManager->remove($bike);
        $entityManager->flush();

        return $this->json('The ' . $brand . ' bike with the id ' . $id . ' has been successfully deleted');
    }
}
