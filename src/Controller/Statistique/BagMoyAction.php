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

            if (isset($_GET['dateFrom']) && isset($_GET['dateTo'])) {
                $qb->where('b.date BETWEEN :dateFrom AND :dateTo')
                    ->setParameter('dateFrom', $_GET['dateFrom'])
                    ->setParameter('dateTo', $_GET['dateTo']);
            }

        $totalbag = $qb->getQuery()
                    ->getSingleScalarResult();


        // calculate average bag price
            $qb = $this->entityManager->createQueryBuilder()
                ->select("SUM(c.unitPrice*c.quantity)/:totalBag")
                ->from(Contain::class, 'c')
                ->setParameter('totalBag', $totalbag);

            // date from and date to
            if (isset($_GET['dateFrom']) && isset($_GET['dateTo'])) {
                $qb->andWhere('c.date BETWEEN :dateFrom AND :dateTo')
                    ->setParameter('dateFrom', $_GET['dateFrom'])
                    ->setParameter('dateTo', $_GET['dateTo']);
            }

            $result = $qb->getQuery()
                ->getSingleScalarResult();
        // return average bag price
        return new JsonResponse(['Panier moyen' => $result]);
    }
}