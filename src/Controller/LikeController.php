<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LikeController extends AbstractController
{
    public function __construct()
    {
    }

//    #[Route('/like/{id}', name: 'like_activity', methods: ['POST'])]
//    public function likeActivity(int $id): JsonResponse
//    {
//        $user = $this->security->getUser();
//
//        $activity = $this->activityRepository->find($id);
//
//        if (!$activity) {
//            return new JsonResponse(['message' => 'Activity not found'], 404);
//        }
//
//        $like = $this->likeRepository->findOneBy(['user' => $user, 'activity' => $activity]);
//
//        if (!$like) {
//            $like = new Like();
//            $like->setUser($user);
//            $like->setActivity($activity);
//            $like->setCreatedAt(new DateTime());
//        } else {
//            $this->likeRepository->remove($like);
//        }
//
//        $this->likeRepository->save($like);
//
//        return new JsonResponse(['message' => 'Like saved'], 200);
//    }
}