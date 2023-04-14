<?php

namespace App\Repository;

use App\Entity\InternalUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<InternalUser>
 *
 * @method InternalUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method InternalUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method InternalUser[]    findAll()
 * @method InternalUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InternalUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InternalUser::class);
    }

    public function save(InternalUser $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(InternalUser $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return InternalUser[] Returns an array of InternalUser objects
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

//    public function findOneBySomeField($value): ?InternalUser
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

    /**
     * @param string $userEmail
     * @return InternalUser|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findByEmail(string $userEmail): ?InternalUser
    {
            return $this->createQueryBuilder('iu')
            ->andWhere('iu.email = :userEmail')
            ->setParameter('userEmail', $userEmail)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
