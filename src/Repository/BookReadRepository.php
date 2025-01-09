<?php

namespace App\Repository;

use App\Entity\BookRead;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BookRead>
 */
class BookReadRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BookRead::class);
    }

    /**
     * Method to find all ReadBook entities by user_id
     * @param int $userId
     * @param bool $readState
     * @return array
     */
    public function findAllByUserId(User $user, bool $readState): array
    {
        return $this->createQueryBuilder('b')
            ->where('b.user = :user')
            ->andWhere('b.is_read = :read')
            ->setParameter('user', $user)
            ->setParameter('read', $readState)
            ->getQuery()
            ->getResult();

    }
}
