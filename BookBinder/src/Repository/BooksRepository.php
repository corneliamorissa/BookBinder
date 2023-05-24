<?php

namespace App\Repository;
use App\Entity\Books;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\AST\Join;
use Doctrine\Persistence\ManagerRegistry;
use http\QueryString;

/**
 * @extends ServiceEntityRepository<Books>
 *
 * The ORM already provides generic find methods that can be used for querying the db :
 *
 * @method Books|null find($id, $lockMode = null, $lockVersion = null)
 * @method Books|null findOneBy(array $criteria, array $orderBy = null)
 * @method Books[]    findAll()
 * @method Books[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */

class BooksRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Books::class);
    }


    public function getTitleByID(int $ID): string {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery('
        SELECT b.title FROM App\Entity\Books b WHERE b.id = :ID')
            ->setParameter('ID', $ID);
        return $query->getSingleScalarResult();
    }

    public function getLibraryNameById(int $ID): string {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery('
        SELECT c.name
        FROM App\Entity\Library c
        where c.id = :ID
    ')->setParameter('ID', $ID);
        return $query->getSingleScalarResult();
    }

    public function findTopBooks() : array {
        $queryBuilder = $this->createQueryBuilder('b')
            ->select('b.id', 'b.title', 'b.author', 'b.rating','b.isbn', 'b.number_of_followers' )
            ->orderBy('b.rating', 'DESC')
            ->addOrderBy('b.number_of_followers', 'DESC')
            ->setMaxResults(3);

        $result = $queryBuilder->getQuery()->getScalarResult();
        $books = [];
        foreach ($result as $row) {
            $book = [
                'id' => $row['id'],
                'title' => $row['title'],
                'author' => $row['author'],
                'rating' => $row['rating'],
                'isbn' => $row['isbn'],
                'number_of_followers' => $row['number_of_followers'],
            ];
            $books[] = $book;
        }
        return $books;
    }

    public function findBookByISBN(string $isbn): ?array
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery('
            SELECT c.id, c.title, c.author, c.rating, c.isbn, c.number_of_followers
            FROM App\Entity\Books c
            WHERE c.isbn = :isbn
        ')->setParameter('isbn', $isbn);

        return $query->getOneOrNullResult();
    }

}
