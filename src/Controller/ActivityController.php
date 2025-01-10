<?php

namespace App\Controller;

use App\Repository\BookReadRepository;
use App\Repository\BookRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Routing\Annotation\Route;

class ActivityController extends AbstractController
{

    public function __construct(private BookReadRepository $bookReadRepository,
                                private Security $security,
                                private UserRepository $userRepository,
                                private BookRepository $bookRepository)
    {
    }

    #[Route('/activity', name: 'app_activity')]
    public function index()
    {
        $user = $this->security->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }
        $userId     = $user->getId();
        $user = $this->userRepository->find($userId);

        $books = $this->bookRepository->findAll();

        $bookread = $this->bookReadRepository->findAllDetailsByNotUserId($user);

        return $this->render('pages/activity.html.twig', [
            'activities' => $bookread,
            'name'       => 'Activités'
        ]);
    }
}