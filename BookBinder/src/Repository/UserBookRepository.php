<?php

namespace App\Repository;
use App\Entity\UserBook;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserBook>
 *
 * The ORM already provides generic find methods that can be used for querying the db :
 *
 * @method UserBook|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserBook|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserBook[]    findAll()
 * @method UserBook[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserBookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserBook::class);
    }
    public function getBooksByUserID(int $ID) : ?array{
        $entitymanager = $this->getEntityManager();
        $query = $entitymanager->createQuery(
            'SELECT b from App\Entity\UserBook b WHERE b.userid = :ID')
            ->setParameter(':ID', $ID);
        return $query->getResult();
    }

    public function findUserBook(int $userid, int $bookid):?UserBook{
        return $this->findOneBy(['userid'=>$userid, 'bookid'=>$bookid]);
    }

    public function displayFollowedBooksPerUser(int $UserId) : array{
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('ub.id', 'b.title ', 'b.isbn','b.author ', 'ub.userid', 'ub.bookid')
            ->from('App\Entity\UserBook', 'ub')
            ->leftJoin('App\Entity\Books', 'b', 'WITH', 'ub.bookid = b.id')
            ->where('ub.userid = :userId')
            ->setParameter('userId', $UserId);

        $result =  $qb->getQuery()->getScalarResult();
        $books = [];
        foreach ($result as $row) {
            $book = [
                'id'=>$row['bookid'],
                'title' => $row['title'],
                'author' => $row['author'],
                'isbn' => $row['isbn'],
            ];
            $books[] = $book;
        }
        return $books;
    }
}