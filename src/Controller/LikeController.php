<?php

namespace App\Controller;

use App\Entity\Like;
use App\Repository\BookReadRepository;
use App\Repository\LikeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class LikeController extends AbstractController
{
    public function __construct(
        private BookReadRepository $bookReadRepository,
        private LikeRepository $likeRepository,
        private Security $security,
    ) {
    }

    #[Route('/like', name: 'like_activity', methods: ['POST'])]
    public function likeActivity(Request $request): JsonResponse
    {
        $user = $this->security->getUser();

        $id = json_decode($request->getContent(), true)['activityId'];

        $bookread = $this->bookReadRepository->find($id);

        if (! $bookread) {
            return new JsonResponse(['message' => 'Bookread not found'], 404);
        }

        $like = $this->likeRepository->findOneBy(['user' => $user, 'book_read' => $bookread]);

        if (! $like) {
            $like = new Like();
            $like->setUser($user);
            $like->setBookRead($bookread);
            $like->setLike(true);

            try {
                $this->likeRepository->save($like);
            } catch (\Exception $e) {
                return new JsonResponse(['message' => 'Error while saving like'], 500);
            }
        } else {
            $this->likeRepository->invertLike($like);

            return new JsonResponse(['message' => 'Already liked'], 200);
        }

        return new JsonResponse(['message' => $like], 200);
    }
}
