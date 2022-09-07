<?php

namespace App\Controller\front;

use App\Repository\CommentRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/product')]
class ProductController extends AbstractController
{
    #[Route('/{id}', name: 'app_product')]
    public function index(
        ProductRepository $productRepository,
        CommentRepository $commentRepository,
        int $id
    ): Response
    {
        $product = $productRepository->getDetailProduct($id);
        $samecategory = $productRepository->findSameCategory($product[0][0]->getCategory()->getId());
        $samemark = $productRepository->findSameMark($product[0][0]->getMark()->getId());
        $comments = $commentRepository->findAllCommentWithUser($product[0][0]);
        return $this->render('front/product/index.html.twig', [
            'product' => $product,
            'samecategory' => $samecategory,
            'samemark' => $samemark,
            'comments' => $comments,
        ]);
    }
}
