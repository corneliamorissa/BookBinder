<?php

namespace App\Repository;
use App\Entity\Books;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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

       /* $resultArray = $query->getResult();
        $libraryNames = array_column($resultArray, 'library');*/

        return $query->getSingleScalarResult();
    }


}
