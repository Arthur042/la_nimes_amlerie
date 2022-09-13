<?php

namespace App\Controller\front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/checkout')]
class BagController extends AbstractController
{
    #[Route('/', name: 'app_bag')]
    public function index(): Response
    {
        return $this->render('front/bag/index.html.twig', [
        ]);
    }

    #[Route('/address', name: 'app_adress_bag')]
    public function adress(): Response
    {
        return $this->render('front/bag/adress.html.twig', [
        ]);
    }
}
