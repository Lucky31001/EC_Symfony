<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Book>
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    //    /**
    //     * @return Book[] Returns an array of Book objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('b.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Book
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    // src/Repository/BookRepository.php

    // src/Repository/BookRepository.php

    public function findBySearchQuery(?string $query): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT b.id, b.name, b.description, COALESCE(AVG(br.rating), 0) as avgRating
        FROM book b
        LEFT JOIN book_read br ON b.id = br.book_id
    ';

        if ($query !== null && $query !== '') {
            $sql .= ' WHERE b.name LIKE :query';
        }

        $sql .= ' GROUP BY b.id';

        $stmt = $conn->prepare($sql);
        $params = ($query !== null && $query !== '') ? ['query' => '%' . $query . '%'] : [];
        $resultSet = $stmt->executeQuery($params);

        return $resultSet->fetchAllAssociative();
    }
}
