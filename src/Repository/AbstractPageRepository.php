<?php

namespace App\Repository;

use App\Entity\About;
use App\Entity\AbstractPage;
use App\Entity\Blog;
use App\Entity\Contact;
use App\Entity\Gallery;
use App\Entity\Page;
use App\Entity\Service;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AbstractPage>
 *
 * @method AbstractPage|null find($id, $lockMode = null, $lockVersion = null)
 * @method AbstractPage|null findOneBy(array $criteria, array $orderBy = null)
 * @method AbstractPage[]    findAll()
 * @method AbstractPage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AbstractPageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AbstractPage::class);
    }

    public function save(AbstractPage $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(AbstractPage $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findAllWithSections()
    {
        return $this->createQueryBuilder('ap')
            ->leftJoin('ap.sections', 's')
            ->addSelect('s')
            ->orderBy('s.position', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findPublished()
    {
        return $this->createQueryBuilder('ap')
            ->andWhere('ap.isVisible = :isVisible')
            ->setParameter('isVisible', true)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param string $navigationSlug
     * @param string $abstractPageType
     * @return AbstractPage|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findAbstractPageByNavigationSlug(
        string $navigationSlug, string $abstractPageType = AbstractPage::TYPE_PAGE): ?AbstractPage
    {
        $abstractPage = $this->createQueryBuilder('ap')
            ->leftJoin('ap.navigation', 'n')
            ->andWhere('n.slug = :navigationSlug')
            ->setParameters(
                [
                    'navigationSlug' => $navigationSlug,
                ]
            )
            ->getQuery()
            ->getOneOrNullResult();

        if ( $abstractPageType === AbstractPage::TYPE_PAGE && $abstractPage instanceof Page ) {
            return $abstractPage;
        }

        if ( $abstractPageType === AbstractPage::TYPE_BLOG && $abstractPage instanceof Blog ) {
            return $abstractPage;
        }

        if ( $abstractPageType === AbstractPage::TYPE_ABOUT && $abstractPage instanceof About ) {
            return $abstractPage;
        }

        if ( $abstractPageType === AbstractPage::TYPE_CONTACT && $abstractPage instanceof Contact ) {
            return $abstractPage;
        }

        if ( $abstractPageType === AbstractPage::TYPE_GALLERY && $abstractPage instanceof Gallery ) {
            return $abstractPage;
        }

        if ( $abstractPageType === AbstractPage::TYPE_SERVICE && $abstractPage instanceof Service ) {
            return $abstractPage;
        }

        return null;
    }
//    /**
//     * @return AbstractPage[] Returns an array of AbstractPage objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?AbstractPage
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
