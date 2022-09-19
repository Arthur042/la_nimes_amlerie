<?php

namespace App\Controller\front;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/category')]
class CategoryController extends AbstractController
{
    #[Route('/{id}', name: 'app_category_parent')]
    public function index(Category $category, CategoryRepository $categoryRepository): Response
    {
        dd($category);
        $products = $categoryRepository->findAllProductWithParentCategory($category);
        return $this->render('category/index.html.twig', [
            'controller_name' => 'CategoryController',
        ]);
    }
}
