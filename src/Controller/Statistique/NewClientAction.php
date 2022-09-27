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
        $newUsers = $this->entityManager->createQueryBuilder()
                ->select('SUBSTRING(u.inscriptionAt, 9, 2) as name, COUNT(u) as value')
                ->from(User::class, 'u')
                ->groupBy('name')
                ->orderBy('u.inscriptionAt', 'DESC')
                ->setMaxResults(31)
                ->getQuery()
                ->getResult();

        // create request to count total visits
            $totalVisitors = $this->entityManager->createQueryBuilder()
            ->select('SUBSTRING(v.connectionAt, 9, 2) as name, COUNT(v) as value')
            ->from(CountVisitors::class, 'v')
            ->groupBy('name')
            ->orderBy('v.connectionAt', 'DESC')
            ->setMaxResults(31)
            ->getQuery()
            ->getResult();

        $temp = [
            [
              "name" => "Nb nouveau client",
              "series" => []
            ],
            [
              "name" => "Nb visite",
              "series" => []
            ]
          ];

        $result = [
          [
            "name" => "Nb nouveau client",
            "series" => []
          ],
          [
            "name" => "Nb visite",
            "series" => []
          ]
        ];

          for($i = 0; $i < count($newUsers); $i++) {
            array_push($temp[0]['series'], $newUsers[$i]);
          };
          for($i = 0; $i < count($totalVisitors); $i++) {
            array_push($temp[1]['series'], $totalVisitors[$i]);
          };

          for($i = 0; $i < 31; $i++) {
            if(empty($temp[1]['series'][$i])) {
                array_push($temp[1]['series'], [
                    "name" => "$i",
                    "value" => 0
                ]);
            };
          };
          for($i = 0; $i < 31; $i++) {
            $day = 30-$i;
            $temp[0]['series'][$i]['name'] = "$day";
            $temp[1]['series'][$i]['name'] = "$day";
          };
          for($i = 0; $i < 31; $i++) {
            $day = 30-$i;
            array_push($result[0]['series'], $temp[0]['series'][$day]);
            array_push($result[1]['series'], $temp[1]['series'][$day]);
          };


        return new JsonResponse($result);
    }
}