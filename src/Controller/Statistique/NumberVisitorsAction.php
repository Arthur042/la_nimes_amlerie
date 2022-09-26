<?php

namespace App\Controller\Statistique;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\CountVisitors;
use App\Entity\Bag;

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
            $totalVisitors = $this->entityManager->createQueryBuilder()
                                ->select('COUNT(v), SUBSTRING(v.connectionAt, 6, 2) as gbmonth')
                                ->from(CountVisitors::class, 'v')
                                ->groupBy('gbmonth')
                                ->orderBy('v.connectionAt', 'DESC')
                                ->setMaxResults(5)
                                ->getQuery()
                                ->getResult();

        // find total number of bag in database
        $nbBag = $this->entityManager->createQueryBuilder()
            ->select('COUNT(b), SUBSTRING(b.creationAt, 6, 2) as gbmonth')
            ->from(Bag::class, 'b')
            ->groupBy('gbmonth')
            ->orderBy('b.creationAt', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult();

        $result = [
            [
                'name' => 'Nb visite',
                'series' => [
                    [
                        'name' => 'mois 1',
                        'value' => $totalVisitors[4][1]
                    ],
                    [
                        'name' => 'mois 2',
                        'value' => $totalVisitors[3][1]
                    ],
                    [
                        'name' => 'mois 3',
                        'value' => $totalVisitors[2][1]
                    ],
                    [
                        'name' => 'mois 4',
                        'value' => $totalVisitors[1][1]
                    ],
                    [
                        'name' => 'mois 5',
                        'value' => $totalVisitors[0][1]
                    ],
                ]
            ],
            [
                'name' => 'Nb Panier',
                'series' => [
                    [
                        'name' => 'mois 1',
                        'value' => $nbBag[4][1]
                    ],
                    [
                        'name' => 'mois 2',
                        'value' => $nbBag[3][1]
                    ],
                    [
                        'name' => 'mois 3',
                        'value' => $nbBag[2][1]
                    ],
                    [
                        'name' => 'mois 4',
                        'value' => $nbBag[1][1]
                    ],
                    [
                        'name' => 'mois 5',
                        'value' => $nbBag[0][1]
                    ],
                ]
            ],

        ];
        
        // return response
            return new JsonResponse($result);

    }
}