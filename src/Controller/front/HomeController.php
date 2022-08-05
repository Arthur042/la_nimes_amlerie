<?php

namespace App\Controller\front;

use App\Entity\CountVisitors;
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
        EntityManagerInterface $entityManager
    ): Response
    {
        // on load, create a new CountVisitors object and save it in the database
        $countVisitors = new CountVisitors();
        $countVisitors->setConnectionAt(new \DateTime());
        $entityManager->persist($countVisitors);
        $entityManager->flush();

        // Request 15 products from the database
        $products = $productRepository->findForHomePage();



        return $this->render('front/home/index.html.twig', [
            'products' => $products,
        ]);
    }
}
