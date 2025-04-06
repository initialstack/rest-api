<?php declare(strict_types=1);

namespace App\Repositories;

use Ramsey\Uuid\UuidInterface;
use App\Contracts\Interface\Repositories\Storage\PermissionStorageRepositoryInterface;
use App\Contracts\Interface\Repositories\Memory\PermissionMemoryRepositoryInterface;
use App\Contracts\Abstract\PermissionRepositoryAbstract;
use App\Entities\Permission;

final class PermissionRepository extends PermissionRepositoryAbstract
{
    /**
     * Constructs a new PermissionRepository instance.
     *
     * @param PermissionStorageRepositoryInterface $storageRepository
     * @param PermissionMemoryRepositoryInterface $memoryRepository
     */
    public function __construct(
        protected PermissionStorageRepositoryInterface $storageRepository,
        protected PermissionMemoryRepositoryInterface $memoryRepository
    ) {
        parent::__construct(
            storageRepository: $storageRepository,
            memoryRepository: $memoryRepository
        );
    }

    /**
     * Retrieves all permissions, first checking the memory cache and then the storage if necessary.
     *
     * @return array
     */
    public function all(): array
    {
        $memory = $this->memoryRepository->all();

        if (!empty($memory)) {
            return $memory;
        }

        $storage = $this->storageRepository->all();

        return $storage;
    }

    /**
     * Finds a permission by ID, checking memory cache first and then storage if necessary.
     *
     * @param \Ramsey\Uuid\UuidInterface $id
     * @return \App\Entities\Permission|null
     */
    public function findById(UuidInterface $id): ?Permission
    {
        $memory = $this->memoryRepository->findById(id: $id);

        if ($memory !== null) {
            return $memory;
        }

        $storage = $this->storageRepository->findById(id: $id);

        return $storage;
    }

    /**
     * Finds a permission by slug, checking memory cache first and then storage if necessary.
     *
     * @param string $slug
     * @return \App\Entities\Permission|null
     */
    public function findBySlug(string $slug): ?Permission
    {
        $memory = $this->memoryRepository->findBySlug(slug: $slug);

        if ($memory !== null) {
            return $memory;
        }

        $storage = $this->storageRepository->findBySlug(slug: $slug);
        
        return $storage;
    }

    /**
     * Saves a permission to both memory and storage repositories.
     *
     * @param \App\Entities\Permission $permission
     */
    public function save(Permission $permission): void
    {
        $this->memoryRepository->save(permission: $permission);
        $this->storageRepository->save(permission: $permission);
    }

    /**
     * Removes a permission from both memory and storage repositories.
     *
     * @param \App\Entities\Permission $permission
     */
    public function remove(Permission $permission): void
    {
        $this->memoryRepository->remove(permission: $permission);
        $this->storageRepository->remove(permission: $permission);
    }
}
