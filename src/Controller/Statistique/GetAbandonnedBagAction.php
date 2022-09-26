<?php

namespace App\Controller\Statistique;

use App\Entity\Bag;
use App\Enum\PanierStatusEnum;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class GetAbandonnedBagAction extends AbstractController
{

    public function __construct(
        EntityManagerInterface $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }


    public function __invoke(): JsonResponse
    {
        // Count all bags with status EXPIRE
        $abandonned = $this->entityManager->createQueryBuilder()
        ->select('COUNT(b)')
        ->from(Bag::class, 'b')
        ->where('b.status = :status')
        ->setParameter('status', PanierStatusEnum::EXPIRE);

        if (isset($_GET['dateFrom']) && isset($_GET['dateTo'])) {
        $abandonned->andwhere('b.creationAt BETWEEN :dateFrom AND :dateTo')
            ->setParameter('dateFrom', $_GET['dateFrom'])
            ->setParameter('dateTo', $_GET['dateTo']);
        }

        $abandonned = $abandonned->getQuery()->getSingleScalarResult();

        // Count all bags with status COMMANDE
            $commande = $this->entityManager->createQueryBuilder()
                        ->select('COUNT(b)')
                        ->from(Bag::class, 'b')
                        ->where('b.status = :status')
                        ->setParameter('status', PanierStatusEnum::COMMANDE);

            if (isset($_GET['dateFrom']) && isset($_GET['dateTo'])) {
                $commande->andwhere('b.creationAt BETWEEN :dateFrom AND :dateTo')
                    ->setParameter('dateFrom', $_GET['dateFrom'])
                    ->setParameter('dateTo', $_GET['dateTo']);
            }

        $commande = $commande->getQuery()->getSingleScalarResult();

        // Calculate percentage of abandoned bags
            // $result['abandon panier %'] = round(($commande / $total) * 100, 2);

            $response = [[
                "name" => "Panier abandonné",
                "value" => $abandonned
            ],
            [
                "name" => "Commande",
                "value" => $commande
            ]];

        return new JsonResponse($response);
    }
}