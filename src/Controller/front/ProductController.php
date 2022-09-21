<?php

namespace App\Controller\front;

use App\Entity\Product;
use App\Repository\CommentRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
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

        $numberNotes = $commentRepository->CountComment($product[0][0]);
        $numberNotes = $numberNotes[0][1];
        $notes = [
            5 => 0,
            4 => 0,
            3 => 0,
            2 => 0,
            1 => 0,
        ];

        foreach ($comments as $comment) {
            $currentNote = $comment->getNote();

            if ($currentNote > 0 && $currentNote <= 1){
                $notes[1] += 1;
            } elseif ($currentNote > 1 && $currentNote <= 2) {
                $notes[2] += 1;
            } elseif ($currentNote > 2 && $currentNote <= 3) {
                $notes[3] += 1;
            } elseif ($currentNote > 3 && $currentNote <= 4) {
                $notes[4] += 1;
            } elseif ($currentNote > 4 && $currentNote <= 5) {
                $notes[5] += 1;
            }

            $numberNotes++;
        }

        for ($i = 1; $i <= 5; $i++){
            if($notes[$i] != 0) {
                $notes[$i] = ($notes[$i]/$numberNotes)*100;
            }
        }

        return $this->render('front/product/index.html.twig', [
            'product' => $product,
            'samecategory' => $samecategory,
            'samemark' => $samemark,
            'comments' => $comments,
            'notes' => $notes,
        ]);
    }
}
