<?php declare(strict_types=1);

namespace App\Repositories\Memory;

use Ramsey\Uuid\UuidInterface;
use App\Contracts\Interface\Repositories\Memory\PermissionMemoryRepositoryInterface;
use App\Entities\Permission;

final class PermissionMemoryRepository implements PermissionMemoryRepositoryInterface
{
    /**
     * The in-memory collection of permissions.
     *
     * @var array
     */
    private array $collection;

    /**
     * Constructs a new PermissionMemoryRepository instance.
     *
     * @param array $permissions
     */
    public function __construct(array $permissions = [])
    {
        $this->collection = $permissions;
    }

    /**
     * Retrieves all permissions from the in-memory collection.
     *
     * @return array
     */
    public function all(): array
    {
        return array_values(array: $this->collection);
    }

    /**
     * Finds a permission by ID in the in-memory collection.
     *
     * @param \Ramsey\Uuid\UuidInterface $id
     * @return \App\Entities\Permission|null
     */
    public function findById(UuidInterface $id): ?Permission
    {
        return $this->collection[$id->toString()] ?? null;
    }

    /**
     * Finds a permission by slug in the in-memory collection.
     *
     * @param string $slug
     * @return \App\Entities\Permission|null
     */
    public function findBySlug(string $slug): ?Permission
    {
        return $this->collection[$slug] ?? null;
    }

    /**
     * Saves a permission to the in-memory collection.
     *
     * @param \App\Entities\Permission $permission
     */
    public function save(Permission $permission): void
    {
        $this->collection[] = $permission;
    }

    /**
     * Removes a permission from the in-memory collection.
     *
     * @param \App\Entities\Permission $permission
     */
    public function remove(Permission $permission): void
    {
        unset($this->collection[$permission->getId()->toString()]);
    }
}
