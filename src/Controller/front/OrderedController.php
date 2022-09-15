<?php

namespace App\Controller\front;

use App\Entity\Ordered;
use App\Repository\OrderedRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/ordered')]
class OrderedController extends AbstractController
{
    #[Route('/', name: 'app_ordered')]
    public function index(OrderedRepository $orderedRepository): Response
    {

        $ordereds = $orderedRepository->findAllOrderedUser($this->getUser()->getId());
        return $this->render('front/ordered/index.html.twig', [
            'oredereds' => $ordereds,
        ]);
    }

    #[Route('/detail/{id}', name: 'app_ordered_detail')]
    public function orderedDetail(OrderedRepository $orderedRepository): Response
    {

        $ordered = $orderedRepository->findLastOrderOfClient($this->getUser()->getId());
        dump($ordered[0]);
        return $this->render('front/ordered/orderedDetail.html.twig', [
            'ordered' => $ordered[0],
        ]);
    }
}
