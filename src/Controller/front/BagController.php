<?php

namespace App\Controller\front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/bag')]
class BagController extends AbstractController
{
    #[Route('/', name: 'app_bag')]
    public function index(): Response
    {
        return $this->render('front/bag/index.html.twig', [
        ]);
    }
}
