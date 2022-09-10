<?php

namespace App\Service;

use App\Repository\BagRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;

class GetCartOnLoad extends AbstractController
{
    public function __construct(
        private RequestStack $requestStack,
        private BagRepository $bagRepository,
    ){}

    public function FindCart()
    {
        if ($user = $this->getUser()){
            $session = $this->requestStack->getSession();
            if (!$session->has('CART')){
                $bag = $this->bagRepository->findBagIfNotExpired($user);
                if(!empty($bag)) {
                    $session->set('CART', $bag[0]->getId());
                    $qtyTotal = 0;
                    foreach ($bag[0]->getContains() as $contain) {
                        $qtyTotal += $contain->getQuantity();
                    }
                    $session->set('QTY', $qtyTotal);
                }
            }
        }
    }
}