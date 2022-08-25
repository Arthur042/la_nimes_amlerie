<?php

namespace App\Controller\back;

use App\Entity\Ordered;
use App\Form\OrderedType;
use App\Repository\OrderedRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/ordered')]
class OrderedController extends AbstractController
{
    public function __construct(
        private OrderedRepository $orderedRepository
    ){}

    #[Route('/', name: 'app_admin_ordered', methods: ['GET'])]
    public function index(
        Request $request,
        PaginatorInterface $paginator,
    ): Response
    {
        $ordereds = $paginator->paginate(
            $this->orderedRepository->getQbAll(),
            $request->query->getInt('page', 1),
            15
        );

        return $this->render('back/ordered/index.html.twig', [
            'ordereds' => $ordereds,
        ]);
    }

    #[Route('/new', name: 'app_admin_ordered_new', methods: ['GET', 'POST'])]
    public function new()
    {
        // todo lorsque payement accepté, créer la commande à partir d'un panier
    }

    #[Route('/detail/{id}', name: 'app_admin_ordered_show', methods: ['GET'])]
    public function show(Ordered $ordered): Response
    {
        return $this->render('back/ordered/show.html.twig', [
            'ordered' => $ordered,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_ordered_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Ordered $ordered, OrderedRepository $orderedRepository): Response
    {
        $form = $this->createForm(OrderedType::class, $ordered);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $orderedRepository->add($ordered, true);

            return $this->redirectToRoute('app_admin_ordered', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/ordered/edit.html.twig', [
            'ordered' => $ordered,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_ordered_delete')]
    public function delete(Request $request, Ordered $ordered, OrderedRepository $orderedRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ordered->getId(), $request->request->get('_token'))) {
            $orderedRepository->remove($ordered, true);
        }

        return $this->redirectToRoute('app_admin_ordered', [], Response::HTTP_SEE_OTHER);
    }
}
