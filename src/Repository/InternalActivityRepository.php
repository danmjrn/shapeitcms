<?php

namespace App\Repository;

use App\Entity\InternalActivity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<InternalActivity>
 *
 * @method InternalActivity|null find($id, $lockMode = null, $lockVersion = null)
 * @method InternalActivity|null findOneBy(array $criteria, array $orderBy = null)
 * @method InternalActivity[]    findAll()
 * @method InternalActivity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InternalActivityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InternalActivity::class);
    }

    public function save(InternalActivity $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(InternalActivity $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return InternalActivity[] Returns an array of InternalActivity objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?InternalActivity
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

    /**
     * @param string $title
     * @return InternalActivity|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findByTitle(string $title): ?InternalActivity
    {
        return $this->createQueryBuilder('ia')
            ->andWhere('ia.title = :title')
            ->setParameter('title', $title)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
