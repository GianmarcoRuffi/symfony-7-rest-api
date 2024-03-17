<?php
 
namespace App\Controller;
 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Bike;
 
 
#[Route('/api', name: 'api_')]
class BikeController extends AbstractController
{
    #[Route('/bikes', name: 'bike_index', methods:['get'] )]
    public function index(EntityManagerInterface $entityManager): JsonResponse
    {
        
        $products = $entityManager
            ->getRepository(Bike::class)
            ->findAll();
    
        $data = [];
    
        foreach ($products as $product) {
           $data[] = [
               'id' => $product->getId(),
               'brand' => $product->getBrand(),
               'engine_size' => $product->getEngineSize(),
               'color' => $product->getColor(),
           ];
        }
    
        return $this->json($data);
    }
  
  
    #[Route('/bikes', name: 'bike_create', methods:['post'] )]
    public function create(EntityManagerInterface $entityManager, Request $request): JsonResponse
    {
        $bike = new Bike();
        $bike->setBrand($request->request->get('brand'));
        $bike->setEngineSize($request->request->get('engine_size'));
        $bike->setColor($request->request->get('color'));
    
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
  
  
    #[Route('/bikes/{id}', name: 'bike_show', methods:['get'] )]
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
  
#[Route('/bikes/{id}', name: 'bike_update', methods:['put', 'patch'] )]
public function update(EntityManagerInterface $entityManager, Request $request, int $id): JsonResponse
{
    $bike = $entityManager->getRepository(Bike::class)->find($id);

    if (!$bike) {
        return $this->json('No bike found for id: ' . $id, 404);
    }

    $brand = $request->request->get('brand');
    if ($brand !== null) {
        $bike->setBrand($brand);
    }

    $engineSize = $request->request->get('engine_size');
    if ($engineSize !== null) {
        $bike->setEngineSize($engineSize);
    }

    $color = $request->request->get('color');
    if ($color !== null) {
        $bike->setColor($color);
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

  
    #[Route('/bikes/{id}', name: 'bike_delete', methods:['delete'] )]
    public function delete(EntityManagerInterface $entityManager, int $id): JsonResponse
    {
        $bike = $entityManager->getRepository(Bike::class)->find($id);
    
        if (!$bike) {
            return $this->json('No bike found for id: ' . $id, 404);
        }
    
        $entityManager->remove($bike);
        $entityManager->flush();
    
        return $this->json('Deleted successfully the bike with id: ' . $id);
    }
}