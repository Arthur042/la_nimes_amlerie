<?php

namespace App\Controller\front;

use App\Entity\Contain;
use App\Repository\ContainRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/contain')]
class ContainController extends AbstractController
{
    #[Route('/delete/{id}', name: 'app_delete_contain')]
    public function delete(
        Contain $contain,
        ContainRepository $containRepository,
        RequestStack $requestStack,
    ): Response
    {
        if(!empty($contain)){
            $session = $requestStack->getSession();
            $tempContain = $session->get('CONTAIN');
            unset($tempContain[$contain->getProducts()->getId()]);
            $session->set('CONTAIN', $tempContain);
            $containRepository->remove($contain, true);
            $qtyTotal = $session->get('QTY') - $contain->getQuantity();
            $session->set('QTY', $qtyTotal);
        }

        return $this->redirect($_SERVER['HTTP_REFERER']);
    }
}
