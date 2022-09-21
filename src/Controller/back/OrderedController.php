<?php

namespace App\Controller\back;

use App\Entity\Ordered;
use App\Form\Filter\OrderedFilterType;
use App\Form\OrderedType;
use App\Repository\OrderedRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderUpdaterInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/ordered')]
class OrderedController extends AbstractController
{
    public function __construct(
        private OrderedRepository $orderedRepository,
        private EntityManagerInterface $entityManager,
    ){}

    #[Route('/', name: 'app_admin_ordered', methods: ['GET'])]
    public function index(
        Request $request,
        PaginatorInterface $paginator,
        FilterBuilderUpdaterInterface $builderUpdater,
    ): Response
    {
        $qb = $this->orderedRepository->getQbAll();

        $filterForm = $this->createForm(OrderedFilterType::class, null, [
            'method' => 'GET',
        ]);

        if ($request->query->has($filterForm->getName())) {
            $filterForm->submit($request->query->all($filterForm->getName()));
            $builderUpdater->addFilterConditions($filterForm, $qb);
        }

        $ordereds = $paginator->paginate(
            $qb,
            $request->query->getInt('page', 1),
            15
        );

        return $this->render('back/ordered/index.html.twig', [
            'ordereds' => $ordereds,
            'filters' => $filterForm->createView(),
        ]);
    }

    #[Route('/detail/{id}', name: 'app_admin_ordered_show', methods: ['GET'])]
    public function show(int $id): Response
    {
        $ordered = $this->orderedRepository->findOneDetail($id);
        $totalHT = 0;
        $totalTTC = 0;
        $totalTVA = 0;

        return $this->render('back/ordered/show.html.twig', [
            'ordered' => $ordered,
            'totalHT' => $totalHT,
            'totalTTC' => $totalTTC,
            'totalTVA' => $totalTVA,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_ordered_delete')]
    public function delete(Ordered $ordered): Response
    {
        if($ordered = $this->orderedRepository->find($ordered->getId())) {
            $this->entityManager->remove($ordered);
            $this->entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_ordered', [], Response::HTTP_SEE_OTHER);
    }
}
