<?php

namespace App\Repository;

use App\Entity\Like;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Like>
 */
class LikeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Like::class);
    }

    public function save(Like $like): Like
    {
        $this->_em->persist($like);
        $this->_em->flush();

        return $like;
    }

    public function changeLikeStatus(Like $like): Like
    {
        $like->
        $this->_em->persist($like);
        $this->_em->flush();

        return $like;
    }

}
