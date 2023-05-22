<?php
namespace App\Repository;
use App\Entity\Library;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use http\QueryString;

/**
 * @extends ServiceEntityRepository<Library>
 *
 * The ORM already provides generic find methods that can be used for querying the db :
 *
 * @method Library|null find($id, $lockMode = null, $lockVersion = null)
 * @method Library|null findOneBy(array $criteria, array $orderBy = null)
 * @method Library[]    findAll()
 * @method Library[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */

class LibraryRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Library::class);
    }

    public function findNearestLibrary(string $username): ?array
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery('
        SELECT l.id,l.name, l.street, l.housenumber, l.postcode
        FROM App\Entity\Library l
        JOIN App\Entity\User u WITH u.username = :username
        WHERE l.postcode BETWEEN (u.postcode - 100) AND (u.postcode + 100)
        ORDER BY ABS(l.postcode - u.postcode) ASC
    ');
        $query->setParameter('username', $username);
        $query->setMaxResults(1);

        $result = $query->getScalarResult();

        $library = [];
        foreach ($result as $row) {
            $library = [
                'id' => $row['id'],
                'name' => $row['name'],
                'street' => $row['street'],
                'housenumber' => $row['housenumber'],
                'postcode' => $row['postcode'],
            ];
            $library[] = $library;
        }

        return $library;
    }
}