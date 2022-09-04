<?php

namespace App\Controller\back;

use App\Repository\OrderedRepository;
use App\Repository\PublisherRepository;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Knp\Snappy\Pdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PdfController extends AbstractController
{
    #[Route('/admin/ordered/pdf/{id}', name: 'app_admin_ordered_pdf')]
    public function index(
        OrderedRepository $orderedRepository,
        Pdf $knpSnappyPdf,
        int $id
    ): PdfResponse
    {
        $ordered = $orderedRepository->findOneDetail($id);
        $totalHT = 0;
        $totalTTC = 0;
        $totalTVA = 0;

        $html = $this->renderView('back/ordered/pdf/index.html.twig', [
            'ordered' => $ordered,
            'totalHT' => $totalHT,
            'totalTTC' => $totalTTC,
            'totalTVA' => $totalTVA,
        ]);
;

        return new PdfResponse(
            $knpSnappyPdf->getOutputFromHtml($html),
            'commande_'. $id .'.pdf',
        );
    }
}