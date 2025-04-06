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
     * Initializes storage and memory repositories for roles.
     *
     * @param RoleStorageRepositoryInterface $storageRepository
     * @param RoleMemoryRepositoryInterface $memoryRepository
     */
    protected function __construct(
        protected RoleStorageRepositoryInterface $storageRepository,
        protected RoleMemoryRepositoryInterface $memoryRepository
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
     * Retrieves all roles from the storage repository.
     *
     * @return array
     */
    private function getAllRolesFromStorage(): array
    {
        return $this->storageRepository->all();
    }

    /**
     * Saves a collection of roles to the memory repository.
     *
     * @param array $roles
     */
    private function saveRolesToMemory(array $roles): void
    {
        collect(value: $roles)->each(
            callback: function (Role $role): void {
                $this->memoryRepository->save(role: $role);
            }
        );
    }

    /**
     * Initializes the memory repository if it is empty.
     */
    private function initializeMemoryRepository(): void
    {
        if ($this->isMemoryRepositoryEmpty()) {
            $roles = $this->getAllRolesFromStorage();
            $this->saveRolesToMemory(roles: $roles);
        }
    }

    /**
     * Retrieves a collection of all roles from the repository.
     *
     * @return \App\Entities\Role[]
     */
    abstract protected function all(): array;

    /**
     * Retrieves a role by their ID.
     *
     * @param \Ramsey\Uuid\UuidInterface $id
     * @return \App\Entities\Role|null
     */
    abstract protected function findById(UuidInterface $id): ?Role;

    /**
     * Retrieves a role by their slug.
     *
     * @param string $slug
     * @return \App\Entities\Role|null
     */
    abstract protected function findBySlug(string $slug): ?Role;
}
