<?php

namespace App\Controller\front;

use App\Entity\Adress;
use App\Entity\Ordered;
use App\Entity\User;
use App\Enum\PanierStatusEnum;
use App\Form\AdressType;
use App\Repository\AdressRepository;
use App\Repository\BagRepository;
use App\Repository\OrderedRepository;
use App\Repository\PaymentRepository;
use App\Repository\StatusRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/checkout')]
class BagController extends AbstractController
{
    #[Route('/', name: 'app_bag')]
    public function index(): Response
    {
        return $this->render('front/bag/index.html.twig', [
        ]);
    }

    #[Route('/address', name: 'app_adress_bag')]
    public function adress(Request $request, SessionInterface $session, AdressRepository $adressRepository, EntityManagerInterface $entityManager): Response
    {
        if($session->get('CART')){
            /** @var User $user*/
            $user = $this->getUser();
            if(is_null($user->getAdress())){
                $adress = new Adress();
                $form = $this->createForm(AdressType::class, $adress);
                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {
                    $adressRepository->add($adress, true);
                    $user->setAdress($adress);
                    $entityManager->persist($user);
                    $entityManager->flush();
                    return $this->redirectToRoute('app_paiement_bag', [], Response::HTTP_SEE_OTHER);
                }

                return $this->render('front/bag/adress.html.twig', [
                    'newAdress' => $adress,
                    'form' => $form->createView(),
                ]);
            } else {
                $adress = $user->getAdress();
                $form = $this->createForm(AdressType::class, $adress);
                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {
                    $adressRepository->add($adress, true);
                    $user->setAdress($adress);
                    $entityManager->persist($user);
                    $entityManager->flush();
                    return $this->redirectToRoute('app_adress_bag', [], Response::HTTP_SEE_OTHER);
                }

                return $this->render('front/bag/adress.html.twig', [
                    'adress' => $user->getAdress(),
                    'editAdress' => $adress,
                    'formEdit' => $form->createView(),
                ]);
            }
        } else {
            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }


    }

    #[Route('/paiement', name: 'app_paiement_bag')]
    public function paiement(SessionInterface $session): Response
    {
        /** @var User $user*/
        $user = $this->getUser();

        if($session->get('CART')){
            return $this->render('front/bag/paiement.html.twig', [
                'adress' => $user->getAdress(),
            ]);
        } else {
            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }
    }


    #[Route('/validateCart/{datas}', name: 'app_validate_bag')]
    public function validateCart(
        Request $request,
        StatusRepository $statusRepository,
        PaymentRepository $paymentRepository,
        BagRepository $bagRepository,
        SessionInterface $session,
        OrderedRepository $orderedRepository,
        EntityManagerInterface $em,
    ): Response
    {
        $datas = json_decode($request->get('datas'), true);

        if($session->get('CART')){
            $status = $statusRepository->find(1);
            if($datas['paiement'] == 'cb') {
                $paiement = $paymentRepository->find(1);
            } else {
                $paiement = $paymentRepository->find(2);
            }
            $user = $this->getUser();
            $bag = $bagRepository->find($session->get('CART'));
            $bag->setStatus(PanierStatusEnum::COMMANDE);

            $order = new Ordered();
            $order->setStatus($status);
            $order->setPayment($paiement);
            $order->setBillingAdress($user->getAdress());
            $order->setBag($bag);
            $em->persist($order);
            $em->persist($bag);
            $session->remove('CART');
            $session->remove('QTY');
            $em->flush();
        }

        $ordered = $orderedRepository->findLastOrderOfClient($this->getUser()->getId());


        return $this->render('front/bag/validate.html.twig', [
            'ordered' => $ordered[0],
        ]);
    }
}
