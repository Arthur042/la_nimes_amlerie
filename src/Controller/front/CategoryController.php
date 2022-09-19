<?php

namespace App\Controller\front;

use App\Entity\Category;
use App\Form\Filter\FrontProductFilterType;
use App\Repository\ProductRepository;
use Knp\Component\Pager\PaginatorInterface;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderUpdaterInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/category')]
class CategoryController extends AbstractController
{
    #[Route('/{id}', name: 'app_category_parent')]
    public function index(
        Category $category,
        ProductRepository $productRepository,
        PaginatorInterface $paginator,
        Request $request,
        FilterBuilderUpdaterInterface $builderUpdater,
    ): Response
    {
        $qb = $productRepository->findAllProductWithParentCategory($category);
        $filterForm = $this->createForm(FrontProductFilterType::class, null, [
            'method' => 'GET',
        ]);

        if ($request->query->has($filterForm->getName())) {
            $filterForm->submit($request->query->get($filterForm->getName()));
            $builderUpdater->addFilterConditions($filterForm, $qb);
        }

        $products = $paginator->paginate(
            $qb,
            $request->query->getInt('page', 1),
            20
        );

        return $this->render('front/category/index.html.twig', [
            'products' => $products,
            'filters' => $filterForm->createView(),
        ]);
    }
}
