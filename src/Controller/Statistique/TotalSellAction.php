<?php

namespace App\Controller\Statistique;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Ordered;

class TotalSellAction extends AbstractController
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
                ->select('SUM(p.priceHt*c.quantity)')
                ->from(Ordered::class, 'o')
                ->join('o.bag', 'b')
                ->join('b.contains', 'c')
                ->join('c.products', 'p');
            $query = $qb->getQuery();
            $total = $query->getSingleScalarResult();
        // return total sell price
        return new JsonResponse(['Montant total des ventes' => $total]);
    }
}