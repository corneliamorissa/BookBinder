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

}