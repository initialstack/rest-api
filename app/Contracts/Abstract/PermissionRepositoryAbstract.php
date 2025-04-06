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
     * Initializes the storage and memory repositories for permission management.
     *
     * @param \App\Contracts\Interface\Repositories\Storage\PermissionStorageRepositoryInterface $storageRepository
     * @param \App\Contracts\Interface\Repositories\Memory\PermissionMemoryRepositoryInterface $memoryRepository
     */
    protected function __construct(
        protected PermissionStorageRepositoryInterface $storageRepository,
        protected PermissionMemoryRepositoryInterface $memoryRepository
    ) {
        $this->initializeMemoryRepository();
    }

    /**
     * Initializes the memory repository by populating it from the storage repository if it is empty.
     */
    protected function initializeMemoryRepository(): void
    {
        // If the memory repository is empty, populate it from the storage repository.
        if (count(value: $this->memoryRepository->all()) === 0) {
            $collection = collect(value: $this->storageRepository->all());

            // Save each permission from the storage repository into the memory repository.
            $collection->each(callback: function(Permission $permission): void {
                $this->memoryRepository->save(permission: $permission);
            });
        }
    }

    /**
     * Retrieves all permissions.
     *
     * Must be implemented by child classes.
     *
     * @return \App\Entities\Permission[]
     */
    abstract protected function all(): array;

    /**
     * Retrieves a permission by their ID.
     *
     * Must be implemented by child classes.
     *
     * @param \Ramsey\Uuid\UuidInterface $id
     * @return \App\Entities\Permission|null
     */
    abstract protected function findById(UuidInterface $id): ?Permission;

    /**
     * Retrieves a permission by their slug.
     *
     * Must be implemented by child classes.
     *
     * @param string $slug
     * @return \App\Entities\Permission|null
     */
    abstract protected function findBySlug(string $slug): ?Permission;
}
