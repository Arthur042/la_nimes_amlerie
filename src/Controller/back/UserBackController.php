<?php

namespace App\Controller\back;

use App\Entity\User;
use App\Form\Filter\UserFilterType;
use App\Repository\BagRepository;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use App\Repository\UserRepository;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderUpdaterInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/user')]
class UserBackController extends AbstractController
{
    public function __construct(
        private UserRepository $userRepository,
        private BagRepository $bagRepository,
        private CommentRepository $commentRepository,
        private EntityManagerInterface $entityManager,
    ){}

    #[Route('/', name: 'app_admin_user')]
    public function index(
        Request $request,
        PaginatorInterface $paginator,
        FilterBuilderUpdaterInterface $builderUpdater,
    ): Response
    {
        $qb = $this->userRepository->getQbAll();

        $filterForm = $this->createForm(UserFilterType::class, null, [
            'method' => 'GET',
        ]);

        if ($request->query->has($filterForm->getName())) {
            $filterForm->submit($request->query->all($filterForm->getName()));
            $builderUpdater->addFilterConditions($filterForm, $qb);
        }

        $users = $paginator->paginate(
            $qb,
            $request->query->getInt('page', 1),
            15
        );

        return $this->render('back/user_back/index.html.twig', [
            'users' => $users,
            'filters' => $filterForm->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_admin_user_delete')]
    public function delete(User $user): Response
    {
        if($user = $this->userRepository->find($user->getId())) {
            $bags = $this->bagRepository->findBy(['user' => $user]);
            foreach($bags as $bag){
                $user->removeBag($bag);
            }
            $comments = $this->commentRepository->findBy(['user' => $user]);
            foreach($comments as $comment){
                $user->removeComment($comment);
            }
            $this->entityManager->remove($user);
            $this->entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_user');
    }
}
