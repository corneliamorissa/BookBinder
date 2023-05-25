<?php

namespace App\Repository;
use App\Entity\Avatar;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Avatar>
 *
 * The ORM already provides generic find methods that can be used for querying the db :
 *
 * @method Avatar|null find($id, $lockMode = null, $lockVersion = null)
 * @method Avatar|null findOneBy(array $criteria, array $orderBy = null)
 * @method Avatar[]    findAll()
 * @method Avatar[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AvatarRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Avatar::class);
    }


    public function findAllId() : array {
        $entityManager = $this->getEntityManager();
        // ref: https://www.doctrine-project.org/projects/doctrine-orm/en/current/reference/dql-doctrine-query-language.html
        $query = $entityManager->createQuery('
                SELECT a.id FROM App\Entity\Avatar a
        ');
        return $query->getResult();
    }
    public function findAvatarByName(string $username): ?array{
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery('
        SELECT  a.id, a.image
        FROM App\Entity\User u
        JOIN App\Entity\Avatar a 
        WHERE a.id = u.avatar_id
        AND u.username = :username

    ');
        $query->setParameter('username', $username);
        $query->setMaxResults(1);
        $result = $query->getScalarResult();
        $avatar = [];
        foreach ($result as $row) {

            $avatar = [
                'id'   => $row['id'],
                'image' => $row['image'],
            ];
            $avatar[] = $avatar;
        }
        return $avatar;
    }



}