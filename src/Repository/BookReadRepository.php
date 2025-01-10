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


    public function findAllDetailsByUserId(User $user): array
    {
        return $this->createQueryBuilder('br')
            ->select('br.id AS ID, b.name AS bookName, b.description, br.is_read, c.name AS categoryName, br.rating')
            ->join('br.book', 'b')
            ->join('b.category', 'c')
            ->where('br.user = :user')
            ->andWhere('br.is_read = true')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
    }

    public function findAllByUserId(User $user): array
    {
        return $this->createQueryBuilder('br')
            ->select('br.id AS ID, b.name AS bookName, b.description, br.is_read, c.name AS categoryName, br.rating, br.updated_at as updatedAt')
            ->join('br.book', 'b')
            ->join('b.category', 'c')
            ->where('br.user = :user')
            ->andWhere('br.is_read = false')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();

    }

    public function save(BookRead $bookRead): void
    {
        $this->entityManager->persist($bookRead);
        $this->entityManager->flush();
    }
}