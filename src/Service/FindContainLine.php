<?php

namespace App\Service;

use App\Repository\BagRepository;
use Symfony\Component\HttpFoundation\RequestStack;

class FindContainLine
{


    public function __construct(
        private RequestStack $requestStack,
        private BagRepository $bagRepository,
    ){}

    public function GetContaiLine()
    {
        $session = $this->requestStack->getSession();
        if ($session->has('CART')){
            $bag = $this->bagRepository->findBagAndContain($session->get('CART'));
            return $bag;
        }
    }
}