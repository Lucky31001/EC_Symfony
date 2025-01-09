<?php

namespace App\Repository;

use App\Entity\BookRead;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BookRead>
 */
class BookReadRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, BookRead::class);
    }

    /**
     * Method to find all ReadBook entities by user_id
     * @param User $user
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

    public function save(BookRead $bookRead): void
    {
        $this->entityManager->persist($bookRead);
        $this->entityManager->flush();
    }
}