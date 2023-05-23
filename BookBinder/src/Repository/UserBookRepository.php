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

}