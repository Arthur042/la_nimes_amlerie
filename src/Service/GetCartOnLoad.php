<?php

namespace App\Service;

use App\Entity\Bag;
use App\Repository\BagRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;

class GetCartOnLoad extends AbstractController
{
    public function __construct(
        private RequestStack $requestStack,
        private BagRepository $bagRepository,
        private EntityManagerInterface $entityManager,
    ){}

    public function FindCart()
    {
        if ($user = $this->getUser()){
            $session = $this->requestStack->getSession();

            /** @var Bag $bag */
            $bag = $this->bagRepository->findBagIfNotExpired($user);

            if ($session->has('CART')){
                if(!empty($bag)) {
                    if ($session->get('CART') != $bag[0]->getId()){
                        $sessionBag = $this->bagRepository->findOneById($session->get('CART'));
                        $sessionBag[0]->setUser($this->getUser());
                        $bag[0]->setStatus(200);
                        $this->entityManager->persist($sessionBag[0]);
                        $this->entityManager->persist($bag[0]);
                        $this->entityManager->flush();
                    }
                } else{
                    $sessionBag = $this->bagRepository->findOneById($session->get('CART'));
                    $sessionBag[0]->setUser($this->getUser());
                    $this->entityManager->flush();
                }

            } else{
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