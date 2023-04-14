<?php

namespace App\Repository;

use App\Entity\ExternalUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ExternalUser>
 *
 * @method ExternalUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExternalUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExternalUser[]    findAll()
 * @method ExternalUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExternalUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExternalUser::class);
    }

    public function save(ExternalUser $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ExternalUser $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ExternalUser[] Returns an array of ExternalUser objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ExternalUser
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
    /**
     * @param string $userEmail
     * @return ExternalUser|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findByEmail(string $userEmail): ?ExternalUser
    {
        return $this->createQueryBuilder('eu')
            ->andWhere('eu.email = :userEmail')
            ->setParameter('userEmail', $userEmail)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }
}
