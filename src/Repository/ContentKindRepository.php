<?php

namespace App\Repository;

use App\Entity\ContentKind;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ContentKind>
 *
 * @method ContentKind|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContentKind|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContentKind[]    findAll()
 * @method ContentKind[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContentKindRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContentKind::class);
    }

    public function save(ContentKind $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ContentKind $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ContentKind[] Returns an array of ContentKind objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ContentKind
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
    public function findByType(string $type): ?ContentKind
    {
        return $this->findOneBy(['type' => $type]);
    }
}
