<?php declare(strict_types=1);

namespace App\Repositories;

use Ramsey\Uuid\UuidInterface;
use App\Contracts\Interface\Repositories\Storage\RoleStorageRepositoryInterface;
use App\Contracts\Interface\Repositories\Memory\RoleMemoryRepositoryInterface;
use App\Contracts\Abstract\RoleRepositoryAbstract;
use App\Entities\Role;

final class RoleRepository extends RoleRepositoryAbstract
{
    /**
     * Constructs a new RoleRepository instance.
     *
     * @param RoleStorageRepositoryInterface $storageRepository
     * @param RoleMemoryRepositoryInterface $memoryRepository
     */
    public function __construct(
        protected RoleStorageRepositoryInterface $storageRepository,
        protected RoleMemoryRepositoryInterface $memoryRepository
    ) {
        parent::__construct(
            storageRepository: $storageRepository,
            memoryRepository: $memoryRepository
        );
    }

    /**
     * Retrieves all roles, first checking the memory cache and then the storage if necessary.
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
     * Finds a role by ID, checking memory cache first and then storage if necessary.
     *
     * @param \Ramsey\Uuid\UuidInterface $id
     * @return \App\Entities\Role|null
     */
    public function findById(UuidInterface $id): ?Role
    {
        $memory = $this->memoryRepository->findById(id: $id);

        if ($memory !== null) {
            return $memory;
        }

        $storage = $this->storageRepository->findById(id: $id);

        return $storage;
    }

    /**
     * Finds a role by slug, checking memory cache first and then storage if necessary.
     *
     * @param string $slug
     * @return \App\Entities\Role|null
     */
    public function findBySlug(string $slug): ?Role
    {
        $memory = $this->memoryRepository->findBySlug(slug: $slug);

        if ($memory !== null) {
            return $memory;
        }

        $storage = $this->storageRepository->findBySlug(slug: $slug);
        
        return $storage;
    }

    /**
     * Saves a role to both memory and storage repositories.
     *
     * @param \App\Entities\Role $role
     */
    public function save(Role $role): void
    {
        $this->memoryRepository->save(role: $role);
        $this->storageRepository->save(role: $role);
    }

    /**
     * Removes a role from both memory and storage repositories.
     *
     * @param \App\Entities\Role $role
     */
    public function remove(Role $role): void
    {
        $this->memoryRepository->remove(role: $role);
        $this->storageRepository->remove(role: $role);
    }
}
