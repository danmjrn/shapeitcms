<?php


namespace App\Security\AccessControl;


use App\Entity\ExternalUser;
use App\Entity\InternalUser;

use App\Entity\Exception\EntityNotFoundException;
use App\Entity\Exception\EntityNotUpdatedException;

use App\Repository\ExternalUserRepository;
use App\Repository\InternalUserRepository;
use App\Repository\PermissionRepository;
use App\Repository\RoleRepository;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class AccessControl
{
    /**
     * @var ExternalUserRepository
     */
    private ExternalUserRepository $externalUserRepository;

    /**
     * @var InternalUserRepository
     */
    private InternalUserRepository $internalUserRepository;

    /**
     * @var PermissionRepository
     */
    private PermissionRepository $permissionRepository;

    /**
     * @var RoleRepository
     */
    private RoleRepository $roleRepository;

    /**
     * @var RequestStack
     */
    private RequestStack $requestStack;

    /**
     * @var TokenStorageInterface
     */
    private TokenStorageInterface $tokenStorage;

    public const USER_TYPE_EXTERNAL = 'external';
    public const USER_TYPE_INTERNAL = 'internal';

    /**
     * @param int $userId
     * @param string $userType
     * @return UserInterface|null
     */
    private function getUserFromRepository
        (
            int $userId,
            string $userType = self::USER_TYPE_INTERNAL
        ): ?UserInterface
    {
        if ($userType === self::USER_TYPE_INTERNAL)
            $user = $this->internalUserRepository->find($userId);
        elseif ($userType === self::USER_TYPE_EXTERNAL)
            $user = $this->externalUserRepository->find($userId);
        else
            $user = null;

        return $user;
    }

    public function __construct
        (
            ExternalUserRepository $externalUserRepository,
            InternalUserRepository $internalUserRepository,
            PermissionRepository $permissionRepository,
            RoleRepository $roleRepository,
            RequestStack $requestStack,
            TokenStorageInterface $tokenStorage
        )
    {
        $this->externalUserRepository = $externalUserRepository;
        $this->internalUserRepository = $internalUserRepository;
        $this->permissionRepository = $permissionRepository;
        $this->roleRepository = $roleRepository;
        $this->requestStack = $requestStack;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @param int $permissionId
     * @param int $roleId
     * @throws EntityNotFoundException
     * @throws EntityNotUpdatedException
     */
    public function assignPermissionToRole(int $permissionId, int $roleId): void
    {
        $permission = $this->permissionRepository->find($permissionId);

        $role = $this->roleRepository->find($roleId);

        if (is_null($permission) || is_null($role)) throw new EntityNotFoundException();

        $role->assignPermission($permission);

        try {
            $this->roleRepository->save($role);
        }
        catch (\Exception $exception) {
            throw new EntityNotUpdatedException();
        }
    }

    /**
     * @param int $roleId
     * @param int $userId
     * @param string $userType
     * @throws EntityNotFoundException
     * @throws EntityNotUpdatedException
     */
    public function assignRoleToUser(int $roleId, int $userId, string $userType = self::USER_TYPE_INTERNAL): void
    {
        $role = $this->roleRepository->find($roleId);

        $user = $this->getUserFromRepository($userId, $userType);

        if (is_null($role) || is_null($user)) throw new EntityNotFoundException();

        try {
            if ($user instanceof InternalUser) {
                $user->assignRole($role);

                $this->internalUserRepository->save($user);
            }
            elseif ($user instanceof ExternalUser) {
                $user->assignRole($role);

                $this->externalUserRepository->save($user);
            }
        }
        catch (\Exception $exception) {
            throw new EntityNotUpdatedException();
        }
    }

    /**
     * @return UserInterface|null
     */
    public function getAuthenticatedUser(): ?UserInterface
    {
        return $this->tokenStorage->getToken()->getUser();
    }

    /**
     * @param string $slug
     * @param string $userUuid
     * @return bool
     */
    public function hasPermission(string $slug, string $userUuid): bool
    {
        try {
            return ! empty( $this->permissionRepository->findByNameAndUserUuid($userUuid, $slug) );
        }
        catch (\Exception $exception) {
            return false;
        }
    }

    /**
     * @param array $names
     * @param string $userUuid
     * @return bool
     */
    public function hasPermissions(array $names, string $userUuid): bool
    {
        try {
            return ! empty($this->permissionRepository->findByNamesAndUserUuid($userUuid, $names));
        }
        catch (\Exception $exception) {
            return false;
        }
    }

    /**
     * @param string $name
     * @param int $userId
     * @return bool
     */
    public function hasRole(string $name, int $userId): bool
    {
        try {
            return ! is_null($this->roleRepository->findByNameAndUserUuid($name, $userId));
        }
        catch (\Exception $exception) {
            return false;
        }
    }

    /**
     * @param int $permissionId
     * @param int $roleId
     * @throws EntityNotFoundException
     * @throws EntityNotUpdatedException
     */
    public function revokePermissionFromRole(int $permissionId, int $roleId): void
    {
        $permission = $this->permissionRepository->find($permissionId);

        $role = $this->roleRepository->find($roleId);

        if (is_null($permission) || is_null($role)) throw new EntityNotFoundException();

        $role->revokePermission($permission);

        try {
            $this->roleRepository->save($role);
        }
        catch (\Exception $exception) {
            throw new EntityNotUpdatedException();
        }
    }

    /**
     * @param int $roleId
     * @param int $userId
     * @param string $userType
     * @throws EntityNotFoundException
     * @throws EntityNotUpdatedException
     */
    public function revokeRoleFromUser(int $roleId, int $userId, string $userType = self::USER_TYPE_INTERNAL): void
    {
        $role = $this->roleRepository->find($roleId);

        $user = $this->getUserFromRepository($userId, $userType);

        if (is_null($role) || is_null($user)) throw new EntityNotFoundException();

        try {
            if ($user instanceof InternalUser) {
                $user->revokeRole($role);

                $this->internalUserRepository->save($user);
            }
            elseif ($user instanceof ExternalUser) {
                $user->revokeRole($role);

                $this->externalUserRepository->save($user);
            }
        }
        catch (\Exception $exception) {
            throw new EntityNotUpdatedException();
        }
    }
}