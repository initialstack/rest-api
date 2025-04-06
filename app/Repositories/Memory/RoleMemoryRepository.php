<?php declare(strict_types=1);

namespace App\Repositories\Memory;

use Ramsey\Uuid\UuidInterface;
use App\Contracts\Interface\Repositories\Memory\RoleMemoryRepositoryInterface;
use App\Entities\Role;

final class RoleMemoryRepository implements RoleMemoryRepositoryInterface
{
    /**
     * The in-memory collection of roles.
     *
     * @var array
     */
    private array $collection;

    /**
     * Constructs a new RoleMemoryRepository instance.
     *
     * @param array $roles
     */
    public function __construct(array $roles = [])
    {
        $this->collection = $roles;
    }

    /**
     * Retrieves all roles from the in-memory collection.
     *
     * @return array
     */
    public function all(): array
    {
        return array_values(array: $this->collection);
    }

    /**
     * Finds a role by ID in the in-memory collection.
     *
     * @param \Ramsey\Uuid\UuidInterface $id
     * @return \App\Entities\Role|null
     */
    public function findById(UuidInterface $id): ?Role
    {
        return $this->collection[$id->toString()] ?? null;
    }

    /**
     * Finds a role by slug in the in-memory collection.
     *
     * @param string $slug
     * @return \App\Entities\Role|null
     */
    public function findBySlug(string $slug): ?Role
    {
        return $this->collection[$slug] ?? null;
    }

    /**
     * Saves a role to the in-memory collection.
     *
     * @param \App\Entities\Role $role
     */
    public function save(Role $role): void
    {
        $this->collection[] = $role;
    }

    /**
     * Removes a role from the in-memory collection.
     *
     * @param \App\Entities\Role $role
     */
    public function remove(Role $role): void
    {
        unset($this->collection[$role->getId()->toString()]);
    }
}
