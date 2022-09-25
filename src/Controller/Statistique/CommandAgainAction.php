<?php

namespace App\Controller\Statistique;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Ordered;

class CommandAgainAction extends AbstractController
{

    public function __construct(
        EntityManagerInterface $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }


    public function __invoke(): JsonResponse
    {
        // count all ordered from echa clien before $date
            $qb = $this->entityManager->createQueryBuilder()
                ->select('IDENTITY(b.user), COUNT(o)')
                ->from(Ordered::class, 'o')
                ->join('o.bag', 'b');

                if (isset($_GET['dateFrom']) && isset($_GET['dateTo'])) {
                    $qb->where('o.creationAt BETWEEN :dateFrom AND :dateTo')
                        ->setParameter('dateFrom', $_GET['dateFrom'])
                        ->setParameter('dateTo', $_GET['dateTo']);
                }

            $totals = $qb->groupBy('b.user')
                        ->getQuery()
                        ->getScalarResult();

        // loop in total and look if total nomber of command for one user is greater than 1
            $commandForSecondTime = 0;
            $totalCommand = 0;

            foreach ($totals as $total) {
                if ($total['2'] > 1) {
                    $commandForSecondTime += ($total['2'] - 1);
                }
                $totalCommand += $total['2'];
            }

            // Calculate the percentage of command for second time
                $percentage = round((($commandForSecondTime / $totalCommand) * 100),2);
        // return the percentage
        return new JsonResponse(['recurranceCommande' => $percentage]);
    }
}