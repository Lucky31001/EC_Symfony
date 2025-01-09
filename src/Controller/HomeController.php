<?php

namespace App\Controller;

use App\Repository\BookReadRepository;
use App\Repository\BookRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    private BookReadRepository $readBookRepository;

    // Inject the repository via the constructor
    public function __construct(private BookReadRepository $bookReadRepository,
                                private Security $security,
                                private BookRepository $bookRepository,
                                private UserRepository $userRepository)
    {
    }

    #[Route('/', name: 'app.home')]
    public function index(): Response
    {
        $user = $this->security->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }
        $userId     = $user->getId();
        $user = $this->userRepository->find($userId);

        $booksRead  = $this->bookReadRepository->findAllDetailsByUserId($user);
        $booksReading = $this->bookReadRepository->findAllByUserId($user, false);
        $books = $this->bookRepository->findAll();

        return $this->render('pages/home.html.twig', [
            'books'     => $books,
            'booksRead' => $booksRead,
            'booksReading' => $booksReading,
            'name'      => 'Accueil',
            'user'      => $user->getUserIdentifier()
        ]);
    }
}
