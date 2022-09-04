<?php

namespace App\Controller\front;

use App\Entity\Bag;
use App\Entity\Contain;
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
    public static string $QTY = 'QTY';

    #[Route('/addItemToCart/{datas}', name: 'ajax_add_item_to_cart')]
    public function index(
        Request $request,
        SessionInterface $session,
        EntityManagerInterface $em,
        ProductRepository $productRepository,
        ContainRepository $containRepository
    ): Response
    {

        $datas = json_decode($request->get('datas'), true);
        $currentSession = [];
        $cart = null;

        if (!$session->has(self::$CART)) {
            $cart = new Bag();
            $cart->setCreationAt(new \DateTime('now'));
            $em->persist($cart);
            $em->flush();
            $session->set(self::$CART, $cart);
        } else {
            $cart = $session->get(self::$CART);
            $currentSession = $session->get(self::$CONTAIN);
        }


        if (isset($currentSession[$datas['gameId']])) {
            $contain =$containRepository->findOneBy(['id' => $currentSession[$datas['gameId']]->getId()]);
            $contain->setQuantity($contain->getQuantity() + $datas['qty']);
            $em->persist($contain);
            $em->flush();
            $session->set(self::$CONTAIN, [$datas['gameId'] => $contain]);
            dd($session);

        } else {
            $product = $productRepository->findOneBy(['id' => $datas['gameId']]);
            $contain = new Contain();
            $contain->setProducts($product);
            $contain->setQuantity($datas['qty']);
            $contain->setBag($cart);
            $contain->setUnitPrice($product->getPriceHt());
            $contain->setTva($product->getTva());
            $em->persist($contain);
            $em->flush();
            $session->set(self::$CONTAIN, [$datas['gameId'] => $contain]);

        }



        $qtyTotal = 0;

        return new JsonResponse(['qtyTotale' => $qtyTotal]);
    }

}