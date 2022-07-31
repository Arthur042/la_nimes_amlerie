<?php

namespace App\Controller\Statistique;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\CountVisitors;
use App\Entity\Bag;

class ConversionBagAction extends AbstractController
{

    public function __construct(
        EntityManagerInterface $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }


    public function __invoke(): JsonResponse
    {
        // create request to count total visits
            $TotalVisitors = $this->entityManager->createQueryBuilder()
                                ->select('COUNT(v)')
                                ->from(CountVisitors::class, 'v');
        
        // create request to count total bag
            $totalBag = $this->entityManager->createQueryBuilder()
                        ->select('Count(b)')
                        ->from(Bag::class, 'b');

        // execute request and stock result in a variable
            $TotalVisitors = $TotalVisitors->getQuery()->getSingleScalarResult();
            $totalBag = $totalBag->getQuery()->getSingleScalarResult();

        // Create response
            $response = [
                'total_visitors' => $TotalVisitors,
                'total_bag' => $totalBag,
                'conversion' => round(($totalBag / $TotalVisitors) * 100, 2),
            ];
        
        // return response
            return new JsonResponse($response);

    }
}