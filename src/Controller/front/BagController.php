<?php

namespace App\Controller\front;

use App\Entity\Adress;
use App\Entity\User;
use App\Form\AdressType;
use App\Repository\AdressRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
    public function adress(Request $request, AdressRepository $adressRepository, EntityManagerInterface $entityManager): Response
    {
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


    }

    #[Route('/paiement', name: 'app_paiement_bag')]
    public function paiement(): Response
    {
        /** @var User $user*/
        $user = $this->getUser();

        return $this->render('front/bag/paiement.html.twig', [
            'adress' => $user->getAdress(),
        ]);


    }
}
