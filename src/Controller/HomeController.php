<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\CountVisitors;

class HomeController extends AbstractController
{

    // Construct with EntityManagerInterface and Request
    public function __construct(
        EntityManagerInterface $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/home', name: 'app_home')]
    public function index(): Response
    {
        // on load, create a new CountVisitors object
            $countVisitors = new CountVisitors();
            $countVisitors->setConnectionAt(new \DateTime());
        // add to the database
            $this->entityManager->persist($countVisitors);
            $this->entityManager->flush();

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
