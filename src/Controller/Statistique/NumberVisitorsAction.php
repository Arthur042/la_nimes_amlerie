<?php

namespace App\Controller\Statistique;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\CountVisitors;

class NumberVisitorsAction extends AbstractController
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

        // execute request and stock result in a variable
            $TotalVisitors = $TotalVisitors->getQuery()->getSingleScalarResult();
        
        // return response
            return new JsonResponse(['Nombre de visites' => $TotalVisitors]);

    }
}