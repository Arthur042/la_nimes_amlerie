<?php

namespace App\Controller\front;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/comment')]
class CommentController extends AbstractController
{
    #[Route('/{id}', name: 'app_comment')]
    public function index(Product $product): Response
    {
        dump($product);
        return $this->render('front/comment/index.html.twig', [
            'controller_name' => 'CommentController',
        ]);
    }
}
