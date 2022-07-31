<?php

namespace App\Controller\Statistique;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Ordered;
use App\Entity\Bag;

class ConversionOrderedAction extends AbstractController
{

    public function __construct(
        EntityManagerInterface $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }


    public function __invoke(): JsonResponse
    {
        // create request to get all bags and ordereds
            $totalBag = $this->entityManager->createQueryBuilder()
                        ->select('Count(b)')
                        ->from(Bag::class, 'b');

            $totalOrder = $this->entityManager->createQueryBuilder()
                        ->select('Count(o)')
                        ->from(Ordered::class, 'o');

        // execute request and stock result in a variable
            $totalBag = $totalBag->getQuery()->getSingleScalarResult();
            $totalOrder = $totalOrder->getQuery()->getSingleScalarResult();

        // Create response
            $response = [
                'total_bag' => $totalBag,
                'total_order' => $totalOrder,
                'conversion' => round(($totalOrder / $totalBag) * 100, 2),
            ];
        
        // return response
            return new JsonResponse($response);

    }
}