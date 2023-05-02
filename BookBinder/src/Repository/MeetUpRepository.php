<?php

namespace App\Repository;
use App\Entity\MeetUp;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
/**
 * @extends ServiceEntityRepository<MeetUp>
 *
 * The ORM already provides generic find methods that can be used for querying the db :
 *
 * @method MeetUp|null find($id, $lockMode = null, $lockVersion = null)
 * @method MeetUp|null findOneBy(array $criteria, array $orderBy = null)
 * @method MeetUp[]    findAll()
 * @method MeetUp[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MeetUpRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MeetUp::class);
    }
}