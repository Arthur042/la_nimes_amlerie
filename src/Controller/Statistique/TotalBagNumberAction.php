<?php

namespace App\Controller\Statistique;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Bag;

class TotalBagNumberAction extends AbstractController
{

    public function __construct(
        EntityManagerInterface $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }


    public function __invoke(): JsonResponse
    {
        // find total number of bag in database
            $qb = $this->entityManager->createQueryBuilder()
                ->select('COUNT(b)')
                ->from(Bag::class, 'b');

            if (isset($_GET['dateFrom']) && isset($_GET['dateTo'])) {
                $qb->andwhere('b.creationAt BETWEEN :dateFrom AND :dateTo')
                    ->setParameter('dateFrom', $_GET['dateFrom'])
                    ->setParameter('dateTo', $_GET['dateTo']);
            }

        $total = $qb->getQuery()
                ->getSingleScalarResult();
        // return total number of bag
        return new JsonResponse(['totalBag' => $total]);
    }
}