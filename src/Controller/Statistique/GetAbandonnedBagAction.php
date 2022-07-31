<?php

namespace App\Controller\Statistique;

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
            $query = $this->entityManager->createQuery(
                'SELECT COUNT(b) FROM App\Entity\Bag b'
            );
            $total = $query->getSingleScalarResult();
        // Count all bags with status COMMANDE
            $query = $this->entityManager->createQuery(
                'SELECT COUNT(b) FROM App\Entity\Bag b WHERE b.status = :status'
            )->setParameter('status', PanierStatusEnum::COMMANDE);
            $commande = $query->getSingleScalarResult();

        // Calculate percentage of abandoned bags
            $result['abandon panier %'] = round(($commande / $total) * 100, 2);

        return new JsonResponse($result);
    }
}