<?php

namespace App\Controller\Statistique;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Contain;
use App\Entity\Bag;

class BagMoyAction extends AbstractController
{

    public function __construct(
        EntityManagerInterface $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }


    public function __invoke(): JsonResponse
    {
        // Get number of bag in database
            $qb = $this->entityManager->createQueryBuilder()
                ->select('COUNT(b)')
                ->from(Bag::class, 'b');
            $query = $qb->getQuery();
            $totalbag = $query->getSingleScalarResult();
            
        // calculate average bag price
            $qb = $this->entityManager->createQueryBuilder()
                ->select("SUM(c.unitPrice*c.quantity)/:totalBag")
                ->from(Contain::class, 'c')
                ->setParameter('totalBag', $totalbag);
            $query = $qb->getQuery();
            $total = $query->getSingleScalarResult();
        // return average bag price
        return new JsonResponse(['Valeur moyen d\'un panier' => $total]);
    }
}