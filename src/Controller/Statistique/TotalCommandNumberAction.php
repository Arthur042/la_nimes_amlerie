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
        // find total number of command in database
            $qb = $this->entityManager->createQueryBuilder()
                ->select('COUNT(o)')
                ->from(Ordered::class, 'o');

            if (isset($_GET['dateFrom']) && isset($_GET['dateTo'])) {
                $qb->andwhere('o.creationAt BETWEEN :dateFrom AND :dateTo')
                    ->setParameter('dateFrom', $_GET['dateFrom'])
                    ->setParameter('dateTo', $_GET['dateTo']);
            }

            $total = $qb->getQuery()
                    ->getSingleScalarResult();

        // return total number of command
        return new JsonResponse(['Nombre total de commande' => $total]);
    }
}