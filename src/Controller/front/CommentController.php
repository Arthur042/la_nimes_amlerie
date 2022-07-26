<?php

namespace App\Controller\front;

use App\Entity\Comment;
use App\Entity\Product;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/comment')]
class CommentController extends AbstractController
{
    #[Route('/{id}', name: 'app_comment')]
    public function index(Product $product, Request $request, CommentRepository $commentRepository): Response
    {

        $comment = new Comment();
        $comment->setUser($this->getUser());
        $comment->setProduct($product);

        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        dump($this->getUser());
        dump($product);
        dump($comment);
        if ($form->isSubmitted() && $form->isValid()) {
            $commentRepository->add($comment, true);
            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('front/comment/index.html.twig', [
            'comment' => $comment,
            'form' => $form->createView(),
            'product' => $product
        ]);
    }
}
