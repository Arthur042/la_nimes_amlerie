<?php

namespace App\Controller\front;

use App\Entity\CountVisitors;
use App\Repository\CommentRepository;
use App\Repository\MarkRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(
        ProductRepository $productRepository,
        CommentRepository $commentRepository,
        MarkRepository $markRepository,
        EntityManagerInterface $entityManager
    ): Response
    {
        // on load, create a new CountVisitors object and save it in the database
        $countVisitors = new CountVisitors();
        $countVisitors->setConnectionAt(new \DateTime());
        $entityManager->persist($countVisitors);
        $entityManager->flush();

        // Request 15 products from the database if connected
        $products = $productRepository->findForHomePage(); //todo 15 product ordered one timeby user
        // Request 15 last released products from the database if not connected
        $lastReleasedProducts = $productRepository->findLastReleased();
        // Request 15 products most selling from the database
        $bestSellingProducts = $productRepository->findBestSellingProducts();
        // Request 5 las comment from the database
        $lastComments = $commentRepository->findLastComments();
        // Request 6 mark from database
        $marks = $markRepository->findMarks();

        $count = 0;

        return $this->render('front/home/index.html.twig', [
            'products' => $products,
            'bestSellingProducts' => $bestSellingProducts,
            'lastReleasedProducts' => $lastReleasedProducts,
            'lastComments' => $lastComments,
            'count' => $count,
            'marks' => $marks,
        ]);
    }
}
