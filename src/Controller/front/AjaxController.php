<?php

namespace App\Controller\front;

use App\Entity\Bag;
use App\Entity\Contain;
use App\Repository\BagRepository;
use App\Repository\ContainRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/ajax')]
class AjaxController extends AbstractController
{

    public static string $CART = 'CART';
    public static string $CONTAIN = 'CONTAIN';

    #[Route('/addItemToCart/{datas}', name: 'ajax_add_item_to_cart')]
    public function index(
        Request $request,
        SessionInterface $session,
        EntityManagerInterface $em,
        ProductRepository $productRepository,
        ContainRepository $containRepository,
        BagRepository $bagRepository
    ): Response
    {
        $datas = json_decode($request->get('datas'), true);
        $currentSession = $session->has(self::$CONTAIN) ? $session->get(self::$CONTAIN) : [];
        if (!$session->has(self::$CART)) {
            $cart = new Bag();
            if ($user = $this->getUser()){
                $cart->setUser($user);
            }
            $em->persist($cart);
            $em->flush();
            $session->set(self::$CART, $cart->getId());
        }

        $cartId = $session->get(self::$CART);
        $cart = $bagRepository->findOneBy(['id' => $cartId]);
        $product = $productRepository->findOneBy(['id' => $datas['productId']]);

        if (false === isset($currentSession[$datas['productId']])) {
            $contain = new Contain();
            $contain->setProducts($product);
            $contain->setQuantity($datas['qty']);
            $contain->setUnitPrice($product->getPriceHt());
            $contain->setTva($product->getTva());
            $cart->addContain($contain);
            $em->persist($contain);
        } else {
            /** @var Contain $contain */
            $contain = $containRepository->findOneBy(['id' => $currentSession[$product->getId()]]);
            $contain->setQuantity($contain->getQuantity() + $datas['qty']);
        }
        $em->flush();
        $currentSession[$product->getId()] = $contain->getId();

        $session->set(self::$CONTAIN, $currentSession);


        $qtyTotal = 0;
        foreach ($cart->getContains() as $contain) {
            $qtyTotal += $contain->getQuantity();
        }
        $session->set('QTY', $qtyTotal);

        return new JsonResponse([
            'qtyTotale' => $qtyTotal,
        ]);
    }
}