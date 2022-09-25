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

            if (isset($_GET['dateFrom']) && isset($_GET['dateTo'])) {
                $TotalVisitors->andwhere('v.connectionAt BETWEEN :dateFrom AND :dateTo')
                            ->setParameter('dateFrom', $_GET['dateFrom'])
                            ->setParameter('dateTo', $_GET['dateTo']);
            }

        // execute request and stock result in a variable
            $TotalVisitors = $TotalVisitors->getQuery()->getSingleScalarResult();
        
        // return response
            return new JsonResponse(['totalVisite' => $TotalVisitors]);

    }
}