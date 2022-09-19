<?php

namespace App\Controller\front;

use App\Entity\Adress;
use App\Form\AdressType;
use App\Form\EmailType;
use App\Form\PasswordType;
use App\Form\UserType;
use App\Repository\AdressRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user')]
class UserController extends AbstractController
{
    #[Route('/', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('front/user/index.html.twig', [

        ]);
    }

    #[Route('/profil', name: 'app_user_profil')]
    public function profil(
        Request $request,
        AdressRepository $adressRepository,
        EntityManagerInterface $entityManager,
        UserRepository $userRepository,
    ): Response
    {
        $user = $this->getUser();

        if(is_null($user->getAdress())){
            $adress = new Adress();
            $formNewAdress = $this->createForm(AdressType::class, $adress);
            $formNewAdress->handleRequest($request);

            if ($formNewAdress->isSubmitted() && $formNewAdress->isValid()) {
                $adressRepository->add($adress, true);
                $user->setAdress($adress);
                $entityManager->persist($user);
                $entityManager->flush();
                return $this->redirectToRoute('app_user_profil', [], Response::HTTP_SEE_OTHER);
            }

            $formAdress = $formNewAdress->createView();

        } else {
            $adress = $user->getAdress();
            $formEditAdress = $this->createForm(AdressType::class, $adress);
            $formEditAdress->handleRequest($request);

            if ($formEditAdress->isSubmitted() && $formEditAdress->isValid()) {
                $adressRepository->add($adress, true);
                $user->setAdress($adress);
                $entityManager->persist($user);
                $entityManager->flush();
                return $this->redirectToRoute('app_user_profil', [], Response::HTTP_SEE_OTHER);
            }

            $formAdress = $formEditAdress->createView();
        }


        $formMail = $this->createForm(EmailType::class);
        $formMail->handleRequest($request);

        if ($formMail->isSubmitted() && $formMail->isValid()) {
            $user->setEmail($formMail->getData()['mail']);
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('app_user_profil', [], Response::HTTP_SEE_OTHER);
        }

        $formPassword = $this->createForm(PasswordType::class);
        $formPassword->handleRequest($request);

        if ($formPassword->isSubmitted() && $formPassword->isValid()) {



            dump($user->getPassword());
            if(hash('sha256',$formPassword->getData()['oldPassword']) === $user->getPassword()) {
                dd(hash('sha256',$formPassword->getData()['oldPassword']));
                $entityManager->persist($user);
                $entityManager->flush();
                return $this->redirectToRoute('app_user_profil', [], Response::HTTP_SEE_OTHER);
            }
            dd('end');
        }


        $formUser = $this->createForm(UserType::class, $user);
        $formUser->handleRequest($request);

        if ($formUser->isSubmitted() && $formUser->isValid()) {
            $userRepository->add($user, true);
            return $this->redirectToRoute('app_user_profil', [], Response::HTTP_SEE_OTHER);
        }


        return $this->render('front/user/profil.html.twig', [
            'adressForm' => $adress,
            'formAdressNew' => $formAdress,
            'formMail' => $formMail->createView(),
            'formPassword' => $formPassword->createView(),
            'formUser' => $formUser->createView(),
            'adress' => $user->getAdress(),
            'user' => $user
        ]);
    }
}
