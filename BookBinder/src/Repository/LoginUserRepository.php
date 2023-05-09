<?php

namespace App\Repository;
use App\Entity\LoginUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
/**
 * @extends ServiceEntityRepository<LoginUser>
 *
 * The ORM already provides generic find methods that can be used for querying the db :
 *
 * @method LoginUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method LoginUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method LoginUser[]    findAll()
 * @method LoginUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LoginUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LoginUser::class);
    }




}

