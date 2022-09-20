<?php

namespace App\Controller\front;

use App\Entity\Mark;
use App\Form\Filter\FrontMarkFilterType;
use App\Repository\ProductRepository;
use Knp\Component\Pager\PaginatorInterface;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderUpdaterInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/mark')]
class MarkController extends AbstractController
{
    #[Route('/{id}', name: 'app_mark')]
    public function index(
        Mark $mark,
        ProductRepository $productRepository,
        PaginatorInterface $paginator,
        Request $request,
        FilterBuilderUpdaterInterface $builderUpdater,
    ): Response
    {
        $qb = $productRepository->findAllProductWithMark($mark);
        $filterForm = $this->createForm(FrontMarkFilterType::class, null, [
            'method' => 'GET',
        ]);

        if ($request->query->has($filterForm->getName())) {
            $filterForm->submit($request->query->all($filterForm->getName()));
            $builderUpdater->addFilterConditions($filterForm, $qb);
        }

        $products = $paginator->paginate(
            $qb,
            $request->query->getInt('page', 1),
            20
        );

        return $this->render('front/mark/index.html.twig', [
            'products' => $products,
            'filters' => $filterForm->createView(),
            'mark' => $mark,
        ]);
    }
}
