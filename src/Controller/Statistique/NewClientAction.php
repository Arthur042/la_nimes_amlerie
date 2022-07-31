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
                ->from(User::class, 'u')
                ->where('u.inscriptionAt >= :date')
                ->setParameter('date', $date);
            $query = $qb->getQuery();
            $newUsers = $query->getSingleScalarResult();

        return new JsonResponse(['Nombre de nouveaux clients' => $newUsers]);
    }
}