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
    
        $entityManager->persist($bike);
        $entityManager->flush();
    
        $data =  [
            'id' => $bike->getId(),
            'brand' => $bike->getBrand(),
            'engine_size' => $bike->getEngineSize(),
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
    
        $bike->setBrand($request->request->get('brand'));
        $bike->setEngineSize($request->request->get('engine_size'));
        $entityManager->flush();
    
        $data =  [
            'id' => $bike->getId(),
            'brand' => $bike->getBrand(),
            'engine_size' => $bike->getEngineSize(),
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