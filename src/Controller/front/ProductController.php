<?php

namespace App\Controller\front;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/product')]
class ProductController extends AbstractController
{
    #[Route('/{id}', name: 'app_product')]
    public function index(
        Product $product,
        SessionInterface $session,
    ): Response
    {
        return $this->render('front/product/index.html.twig', [
            'product' => $product,
        ]);
    }
}
