<?php declare(strict_types=1);

namespace App\Contracts\Abstract;

use Ramsey\Uuid\UuidInterface;
use App\Contracts\Interface\Repositories\RoleRepositoryInterface;
use App\Contracts\Interface\Repositories\Storage\RoleStorageRepositoryInterface;
use App\Contracts\Interface\Repositories\Memory\RoleMemoryRepositoryInterface;
use App\Entities\Role;

abstract class RoleRepositoryAbstract implements RoleRepositoryInterface
{
    /**
     * Constructs a new RoleRepositoryAbstract instance.
     *
     * Initializes the storage and memory repositories for role management.
     *
     * @param \App\Contracts\Interface\Repositories\Storage\RoleStorageRepositoryInterface $storageRepository
     * @param \App\Contracts\Interface\Repositories\Memory\RoleMemoryRepositoryInterface $memoryRepository
     */
    protected function __construct(
        protected RoleStorageRepositoryInterface $storageRepository,
        protected RoleMemoryRepositoryInterface $memoryRepository
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

            // Save each role from the storage repository into the memory repository.
            $collection->each(callback: function(Role $role): void {
                $this->memoryRepository->save(role: $role);
            });
        }
    }

    /**
     * Retrieves all roles.
     *
     * Must be implemented by child classes.
     *
     * @return \App\Entities\Role[]
     */
    abstract protected function all(): array;

    /**
     * Retrieves a role by their ID.
     *
     * Must be implemented by child classes.
     *
     * @param \Ramsey\Uuid\UuidInterface $id
     * @return \App\Entities\Role|null
     */
    abstract protected function findById(UuidInterface $id): ?Role;

    /**
     * Retrieves a role by their slug.
     *
     * Must be implemented by child classes.
     *
     * @param string $slug
     * @return \App\Entities\Role|null
     */
    abstract protected function findBySlug(string $slug): ?Role;
}
