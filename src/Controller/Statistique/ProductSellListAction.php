<?php

namespace App\Controller\Statistique;

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
        $query = $this->entityManager->createQuery(
            'SELECT p.title, 
                    SUM(c.quantity) AS nb_sell,
                    SUM(c.quantity) * c.unitPrice AS total_price
            FROM App\Entity\Ordered o
            JOIN o.bag b
            JOIN b.contains c
            JOIN c.products p
            GROUP BY c.products
            ORDER BY nb_sell DESC'
        )
        ->setMaxResults(100);
        $products = $query->getScalarResult();

        
        // return response
            return new JsonResponse($products);

    }
}