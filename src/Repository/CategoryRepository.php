<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Category>
 */
class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    //    /**
    //     * @return Category[] Returns an array of Category objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Category
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function getCategoriesWithBookReadCountByUserId(int $userId): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT c.id AS category_id, c.name AS category_name, COUNT(br.id) AS book_read_count
        FROM category c
        LEFT JOIN book_category bc ON bc.category_id = c.id
        LEFT JOIN book b ON b.id = bc.book_id 
        LEFT JOIN book_read br ON br.book_id = b.id AND br.user_id = :userId AND br.is_read = true
        GROUP BY c.id, c.name
    ';

        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['userId' => $userId]);

        return $resultSet->fetchAllAssociative();
    }
}
