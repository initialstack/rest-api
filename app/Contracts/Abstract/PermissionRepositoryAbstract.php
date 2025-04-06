<?php declare(strict_types=1);

namespace App\Contracts\Abstract;

use Ramsey\Uuid\UuidInterface;
use App\Contracts\Interface\Repositories\PermissionRepositoryInterface;
use App\Contracts\Interface\Repositories\Storage\PermissionStorageRepositoryInterface;
use App\Contracts\Interface\Repositories\Memory\PermissionMemoryRepositoryInterface;
use App\Entities\Permission;

abstract class PermissionRepositoryAbstract implements PermissionRepositoryInterface
{
    /**
     * Constructs a new PermissionRepositoryAbstract instance.
     *
     * Initializes storage and memory repositories for permissions.
     *
     * @param PermissionStorageRepositoryInterface $storageRepository
     * @param PermissionMemoryRepositoryInterface $memoryRepository
     */
    protected function __construct(
        protected PermissionStorageRepositoryInterface $storageRepository,
        protected PermissionMemoryRepositoryInterface $memoryRepository
    ) {
        $this->initializeMemoryRepository();
    }

    /**
     * Checks if the memory repository is empty.
     *
     * @return bool
     */
    private function isMemoryRepositoryEmpty(): bool
    {
        return count(value: $this->memoryRepository->all()) === 0;
    }

    /**
     * Retrieves all permissions from the storage repository.
     *
     * @return array
     */
    private function getAllPermissionsFromStorage(): array
    {
        return $this->storageRepository->all();
    }

    /**
     * Saves a collection of permissions to the memory repository.
     *
     * @param array $permissions
     */
    private function savePermissionsToMemory(array $permissions): void
    {
        collect(value: $permissions)->each(
            callback: function (Permission $permission): void {
                $this->memoryRepository->save(permission: $permission);
            }
        );
    }

    /**
     * Initializes the memory repository if it is empty.
     */
    private function initializeMemoryRepository(): void
    {
        if ($this->isMemoryRepositoryEmpty()) {
            $permissions = $this->getAllPermissionsFromStorage();
            $this->savePermissionsToMemory(permissions: $permissions);
        }
    }

    /**
     * Retrieves a collection of all permissions from the repository.
     *
     * Must be implemented by child classes.
     *
     * @return \App\Entities\Permission[]
     */
    abstract protected function all(): array;

    /**
     * Retrieves a permission by their ID.
     *
     * @param \Ramsey\Uuid\UuidInterface $id
     * @return \App\Entities\Permission|null
     */
    abstract protected function findById(UuidInterface $id): ?Permission;

    /**
     * Retrieves a permission by their slug.
     *
     * @param string $slug
     * @return \App\Entities\Permission|null
     */
    abstract protected function findBySlug(string $slug): ?Permission;
}
