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
        // Count all bags
            $total = $this->entityManager->createQueryBuilder()
                    ->select('Count(b)')
                    ->from(Bag::class, 'b');

            if (isset($_GET['dateFrom']) && isset($_GET['dateTo'])) {
                $total->where('b.creationAt BETWEEN :dateFrom AND :dateTo')
                    ->setParameter('dateFrom', $_GET['dateFrom'])
                    ->setParameter('dateTo', $_GET['dateTo']);
            }

            $total = $total->getQuery()->getSingleScalarResult();

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
            $result['abandonnedBag'] = round(($commande / $total) * 100, 2);

        return new JsonResponse($result);
    }
}