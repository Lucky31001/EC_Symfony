<?php

namespace App\Controller;

use App\Entity\BookRead;
use App\Repository\BookReadRepository;
use App\Repository\BookRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Psr\Log\LoggerInterface;

class BookController extends AbstractController
{
    public function __construct(private BookRepository $bookRepository,
                                private UserRepository $userRepository,
                                private Security $security,
                                private BookReadRepository $bookReadRepository)
    {
    }

    #[Route('/book/read', name: 'book_read', methods: ['POST'])]
    public function saveBookRead(Request $request, LoggerInterface $logger): Response
    {
        $user = $this->security->getUser();

        $bookId = $request->request->get('book');
        $rating = $request->request->get('rating');
        $description = $request->request->get('description');
        $isRead = $request->request->get('check') ? true : false;

        $book = $this->bookRepository->find($bookId);
        if (!$book) {
            $logger->error('Book not found');
            return new Response('Book not found', 404);
        }

        $user = $this->userRepository->find($user->getId());

        $bookRead = new BookRead();
        $bookRead->setUser($user);
        $bookRead->setBook($book);
        $bookRead->setRating($rating);
        $bookRead->setDescription($description);
        $bookRead->setRead($isRead);
        $bookRead->setCreatedAt(new \DateTime());
        $bookRead->setUpdatedAt(new \DateTime());

        try {
            $this->bookReadRepository->save($bookRead);
        } catch (\Exception $e) {
            $logger->error('Database error: ' . $e->getMessage());
            return new Response('Database error', 500);
        }

        return new Response('Book read saved successfully');
    }
}