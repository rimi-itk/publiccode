<?php

namespace App\Repository\Crawler;

use App\Entity\Crawler\Logs;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Logs>
 *
 * @method Logs|null find($id, $lockMode = null, $lockVersion = null)
 * @method Logs|null findOneBy(array $criteria, array $orderBy = null)
 * @method Logs[]    findAll()
 * @method Logs[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LogsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Logs::class);
    }
}
