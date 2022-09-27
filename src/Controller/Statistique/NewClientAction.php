<?php

namespace App\Controller\Statistique;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\User;

class NewClientAction extends AbstractController
{

    public function __construct(
        EntityManagerInterface $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }


    public function __invoke(): JsonResponse
    {
        // take first day of current month and stock result in a variable
        $date = new \DateTime('first day of this month');
        $date = date('Y-m-d', strtotime($date->format('Y-m-d')));

        // Find new users (user inserted in the base during current month)
            $qb = $this->entityManager->createQueryBuilder()
                ->select('COUNT(u)')
                ->from(User::class, 'u');
        if (isset($_GET['dateFrom']) && isset($_GET['dateTo'])) {
            $qb->where('u.inscriptionAt BETWEEN :dateFrom AND :dateTo')
                ->setParameter('dateFrom', $_GET['dateFrom'])
                ->setParameter('dateTo', $_GET['dateTo'])
                ->andWhere('u.inscriptionAt <= :expireDate')
                ->setParameter('expireDate', 'u.inscriptionAt + 1 month');
        } else {
            $qb->where('u.inscriptionAt >= :date')
                ->setParameter('date', $date);
        }
            $newUsers = $qb->getQuery()
                        ->getSingleScalarResult();

        return new JsonResponse(['Nombre de nouveaux clients' => $newUsers]);
    }
}