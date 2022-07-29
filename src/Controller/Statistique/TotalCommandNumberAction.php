<?php

namespace App\Controller\Statistique;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Ordered;

class TotalCommandNumberAction extends AbstractController
{

    public function __construct(
        EntityManagerInterface $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }


    public function __invoke(): JsonResponse
    {
        // find total sell price
            $qb = $this->entityManager->createQueryBuilder()
                ->select('COUNT(o)')
                ->from(Ordered::class, 'o');
            $query = $qb->getQuery();
            $total = $query->getSingleScalarResult();
        // return total sell price
        return new JsonResponse(['Nombre total de commande' => $total]);
    }
}