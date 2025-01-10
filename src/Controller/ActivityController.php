<?php

namespace App\Controller;

use App\Repository\BookReadRepository;
use App\Repository\BookRepository;
use App\Repository\LikeRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Routing\Annotation\Route;

class ActivityController extends AbstractController
{
    public function __construct(private BookReadRepository $bookReadRepository,
        private Security $security,
        private UserRepository $userRepository,
        private BookRepository $bookRepository,
        private LikeRepository $likeRepository)
    {
    }

    #[Route('/activity', name: 'app_activity')]
    public function index()
    {
        $user = $this->security->getUser();
        if (! $user) {
            return $this->redirectToRoute('app_login');
        }
        $userId = $user->getId();
        $user = $this->userRepository->find($userId);

        $bookread = $this->bookReadRepository->findAllDetailsByNotUserId($user);

        $like = $this->likeRepository->findAll();

        //        dd($like);
        return $this->render('pages/activity.html.twig', [
            'activities' => $bookread,
            'name' => 'Activités',
        ]);
    }
}
