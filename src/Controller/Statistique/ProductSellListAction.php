<?php

namespace App\Controller\Statistique;

use App\Entity\Ordered;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class ProductSellListAction extends AbstractController
{

    public function __construct(
        EntityManagerInterface $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }


    public function __invoke(): JsonResponse
    {
        // create request to find all products with number of sell and total price sold

        $qb = $this->entityManager->createQueryBuilder()
            ->select('p.title, SUM(c.quantity) AS nb_sell, SUM(c.quantity) * c.unitPrice AS total_price')
            ->from(Ordered::class, 'o')
            ->join('o.bag', 'b')
            ->join('b.contains', 'c')
            ->join('c.products', 'p');

        if (isset($_GET['dateFrom']) && isset($_GET['dateTo'])) {
            $qb->where('o.creationAt BETWEEN :dateFrom AND :dateTo')
                ->setParameter('dateFrom', $_GET['dateFrom'])
                ->setParameter('dateTo', $_GET['dateTo']);
        }

        $products = $qb->groupBy('c.products')
                    ->orderBy('nb_sell', 'DESC')
                    ->setMaxResults(100)
                    ->getQuery()
                    ->getResult();

        
        // return response
            return new JsonResponse($products);

    }
}