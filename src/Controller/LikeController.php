<?php

namespace App\Controller;

use App\Entity\Like;
use App\Repository\BookReadRepository;
use App\Repository\LikeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class LikeController extends AbstractController
{
    public function __construct(
        private BookReadRepository $bookReadRepository,
        private LikeRepository $likeRepository,
        private Security $security
    )
    {
    }

    #[Route('/like/{id}', name: 'like_activity', methods: ['POST'])]
    public function likeActivity(int $id): JsonResponse
    {
        $user = $this->security->getUser();

        $bookread = $this->bookReadRepository->find($id);

        if (!$bookread) {
            return new JsonResponse(['message' => 'Bookread not found'], 404);
        }

        $like = $this->likeRepository->findOneBy(['user' => $user, 'bookread' => $bookread]);

        if (!$like) {
            $like = new Like();
            $like->setUser($user);
            $like->setBookRead($bookread);

            $this->likeRepository->save($like);
        } else {
            $this->likeRepository->changeLikeStatus($like);
        }

        return new JsonResponse(['message' => 'Like add !'], 200);
    }
}