<?php

namespace App\Repository\Crawler;

use App\Entity\Crawler\Software;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Software>
 *
 * @method Software|null find($id, $lockMode = null, $lockVersion = null)
 * @method Software|null findOneBy(array $criteria, array $orderBy = null)
 * @method Software[]    findAll()
 * @method Software[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SoftwareRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Software::class);
    }
}
