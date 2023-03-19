<?php

namespace App\Repository;

use App\Entity\Crawler\PublisherCodeHosting;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PublisherCodeHosting>
 *
 * @method PublisherCodeHosting|null find($id, $lockMode = null, $lockVersion = null)
 * @method PublisherCodeHosting|null findOneBy(array $criteria, array $orderBy = null)
 * @method PublisherCodeHosting[]    findAll()
 * @method PublisherCodeHosting[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PublisherCodeHostingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PublisherCodeHosting::class);
    }

    public function save(PublisherCodeHosting $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(PublisherCodeHosting $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return PublisherCodeHosting[] Returns an array of PublisherCodeHosting objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?PublisherCodeHosting
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
