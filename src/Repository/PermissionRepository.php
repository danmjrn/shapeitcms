<?php

namespace App\Repository;

use App\Entity\Permission;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Permission>
 *
 * @method Permission|null find($id, $lockMode = null, $lockVersion = null)
 * @method Permission|null findOneBy(array $criteria, array $orderBy = null)
 * @method Permission[]    findAll()
 * @method Permission[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PermissionRepository extends ServiceEntityRepository
{
    /**
     * PermissionRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Permission::class);
    }

    /**
     * @param Permission $permission
     * @return void
     */
    public function delete(Permission $permission): void
    {
        $this->getEntityManager()->remove($permission);
        $this->getEntityManager()->flush();
    }

    /**
     * @param string $name
     * @return Permission|null
     */
    public function findByName(string $name): ?Permission
    {
        return $this->findOneBy(['name' => $name]);
    }

    /**
     * @param string $userUuid
     * @param string $name
     * @return Permission|null
     * @throws NonUniqueResultException
     */
    public function findByNameAndUserUuid(string $userUuid, string $name): ?Permission
    {
        return $this->createQueryBuilder('p')
            ->join('p.roles', 'r')
            ->join('r.users', 'iu')
            ->where('p.name = :name')
            ->andWhere('iu.uuid = :userUuid')
            ->setParameters
            (
                [
                    'userUuid' => $userUuid,
                    'slug' => $name,
                ]
            )
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @param string $userUuid
     * @param array $names
     * @return array
     */
    public function findByNamesAndUserUuid(string $userUuid, array $names): array
    {
        return $this->createQueryBuilder('p')
            ->join('p.roles', 'r')
            ->join('r.users', 'iu')
            ->where('p.name IN (:names)')
            ->andWhere('iu.uuid = :userUuid')
            ->setParameters
            (
                [
                    'internalUserUuid' => $userUuid,
                    'names' => $names,
                ]
            )
            ->groupBy('p.id')
            ->getQuery()
            ->getResult();
    }

    /**
     * @param int $roleId
     * @return array
     */
    public function findByRoleId(int $roleId): array
    {
        return $this->createQueryBuilder('p')
            ->join('p.roles', 'role')
            ->where('role.id = :role')
            ->setParameter('role', $roleId)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param Permission $permission
     * @return void
     */
    public function save(Permission $permission): void
    {
        $this->getEntityManager()->persist($permission);
        $this->getEntityManager()->flush();
    }
}