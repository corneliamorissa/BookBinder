<?php

namespace App\Repository;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
/**
 * @extends ServiceEntityRepository<User>
 *
 * The ORM already provides generic find methods that can be used for querying the db :
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @return User[] all users that have books
     */
    public function findAllWithAvatar() : array {
        $entityManager = $this->getEntityManager();
        // selecting u and a results in fully hydrated objects (alternative to eager loading)
        $query = $entityManager->createQuery('
                SELECT u, a FROM App\Entity\User u 
                INNER JOIN u.avatar_id a
        ');
        return $query->getResult();
    }

    public function findUserByName(string $username): ?array{
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery('
        SELECT u.first_name, u.last_name, u.birthdate, u.street, u.house_number, u.postcode
        FROM App\Entity\User u
        WHERE u.username = :username
    ');
        $query->setParameter('username', $username);
        $query->setMaxResults(1);
        $result = $query->getScalarResult();
        $user = [];

        foreach ($result as $row) {
            $user = [
                'first_name' => $row['first_name'],
                'last_name' => $row['last_name'],
                'birthdate' => $row['birthdate'],
                'street' => $row['street'],
                'house_number' => $row['house_number'],
                'postcode' => $row['postcode'],
            ];
            $user[] = $user;
        }
        return $user;
    }

}