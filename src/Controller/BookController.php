<?php

namespace App\Controller;

use App\Entity\BookRead;
use App\Repository\BookReadRepository;
use App\Repository\BookRepository;
use App\Repository\UserRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Psr\Log\LoggerInterface;

class BookController extends AbstractController
{
    public function __construct(private BookRepository $bookRepository,
                                private UserRepository $userRepository,
                                private Security $security,
                                private BookReadRepository $bookReadRepository,
                                private LoggerInterface $logger,)
    {
    }

    #[Route('/book/read', name: 'book_read', methods: ['POST'])]
    public function saveBookRead(Request $request, LoggerInterface $logger): JsonResponse
    {
        $user = $this->security->getUser();

        $data = json_decode($request->getContent(), true);

        $bookId = $data['book'];
        $rating = $data['rating'];
        $description = $data['description'];
        $isRead = $data['is_read'];

        $book = $this->bookRepository->find($bookId);

        if (!$book) {
            $this->logger->error('Book not found');
            return new JsonResponse(['message' => 'Book not found'], 404);
        }

        $user = $this->userRepository->find($user->getId());

        $bookRead = $this->bookReadRepository->findOneBy(['user' => $user, 'book' => $book]);

        $gonnaUpdate = false;
        if (!$bookRead) {
            $gonnaUpdate = true;
            $bookRead = new BookRead();
            $bookRead->setUser($user);
            $bookRead->setBook($book);
            $bookRead->setCreatedAt(new DateTime());
        }

        $bookRead->setRating($rating);
        $bookRead->setDescription($description);
        $bookRead->setRead($isRead);
        $bookRead->setUpdatedAt(new DateTime());

        try {
            $this->bookReadRepository->save($bookRead);
        } catch (\Exception $e) {
            $this->logger->error('Database error: ' . $e->getMessage());
            return new JsonResponse(['message' => 'Database error'], 500);
        }

        $category = $book->getCategory()->getValues();

        $category = array_map(function ($category) {
            return $category->getName();
        }, $category);

        $bookRead = [
            'id' => $bookRead->getId(),
            'book' => $bookRead->getBook()->getName(),
            'rating' => $bookRead->getRating(),
            'is_read' => $bookRead->isRead(),
            'category' => $category[0],
            'description' => $bookRead->getDescription(),
            'updated_at' => (new DateTime())->format('Y-m-d H:i:s'),
        ];

        return $this->json([
            'message' => 'Book read saved successfully',
            'methode' => $gonnaUpdate ? 'create' : 'update',
            'bookRead' => $bookRead
        ], Response::HTTP_CREATED);
    }
}