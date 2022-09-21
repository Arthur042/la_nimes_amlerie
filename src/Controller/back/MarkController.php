<?php

namespace App\Controller\back;

use App\Entity\Mark;
use App\Form\MarkType;
use App\Repository\MarkRepository;
use App\Repository\ProductRepository;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/mark')]
class MarkController extends AbstractController
{

    public function __construct(
        private MarkRepository $markRepository,
        private EntityManagerInterface $entityManager,
        private ProductRepository $productRepository,
    ){}

    #[Route('/', name: 'app_admin_mark', methods: ['GET'])]
    public function index(
        PaginatorInterface $paginator,
        Request $request
    ): Response
    {
        $marks = $paginator->paginate(
            $this->markRepository->getQbAll(),
            $request->query->getInt('page', 1),
            15
        );

        return $this->render('back/mark/index.html.twig', [
            'marks' => $marks,
        ]);
    }

    #[Route('/new', name: 'app_admin_mark_new', methods: ['GET', 'POST'])]
    public function new(Request $request, MarkRepository $markRepository, FileUploader $fileUploader): Response
    {
        $mark = new Mark();
        $form = $this->createForm(MarkType::class, $mark);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($form->get('pathImage')->getData() !== null) {
                $file = $fileUploader->uploadFile(
                    $form->get('pathImage')->getData(),
                    '/mark'
                );
                $mark->setpathImage($file);
            }

            $markRepository->add($mark, true);

            return $this->redirectToRoute('app_admin_mark', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/mark/new.html.twig', [
            'mark' => $mark,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_mark_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Mark $mark, MarkRepository $markRepository, FileUploader $fileUploader): Response
    {
        $form = $this->createForm(MarkType::class, $mark);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($form->get('pathImage')->getData() !== null) {
                $file = $fileUploader->uploadFile(
                    $form->get('pathImage')->getData(),
                    '/mark'
                );
                $mark->setpathImage($file);
            }

            $markRepository->add($mark, true);

            return $this->redirectToRoute('app_admin_mark', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/mark/edit.html.twig', [
            'mark' => $mark,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_mark_delete')]
    public function delete(Mark $mark): Response
    {
        $products = $this->productRepository->findBy(['mark' => $mark]);
        foreach($products as $product){
            $mark->removeProduct($product);
        }

        if($mark = $this->markRepository->find($mark->getId())) {
            $this->entityManager->remove($mark);
            $this->entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_mark', [], Response::HTTP_SEE_OTHER);
    }
}
