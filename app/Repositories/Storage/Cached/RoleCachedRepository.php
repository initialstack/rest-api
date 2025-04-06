<?php declare(strict_types=1);

namespace App\Repositories\Storage\Cached;

use App\Entities\Role;
use Illuminate\Support\Facades\Cache;
use App\Contracts\Interface\Repositories\Storage\RoleStorageRepositoryInterface;
use App\Repositories\Storage\Queries\RoleQueryRepository;
use App\Repositories\Storage\Transactions\RoleTransactionRepository;
use Ramsey\Uuid\UuidInterface;
use Carbon\Carbon;

final class RoleCachedRepository implements RoleStorageRepositoryInterface
{
	/**
     * Cache key for storing all roles.
     */
    private const CACHE_ROLE_ALL_KEY = 'roles';

    /**
     * Constructs a new RoleCachedRepository instance.
     *
     * @param RoleQueryRepository $roleQuery
     * @param RoleTransactionRepository $roleTransaction
     */
    public function __construct(
        private RoleQueryRepository $roleQuery,
        private RoleTransactionRepository $roleTransaction
    ) {}

    /**
     * Cache key for storing all roles.
     *
     * @return array
     */
    public function all(): array
    {
        return Cache::flexible(
            key: self::CACHE_ROLE_ALL_KEY,
            ttl: [
                Carbon::now()->addMinutes(value: 5),
                Carbon::now()->addMinutes(value: 15)
            ],
            callback: fn () => $this->roleQuery->all(),
            lock: ['seconds' => 10]
        );
    }

    /**
     * Finds a role by ID directly from the database.
     *
     * @param \Ramsey\Uuid\UuidInterface $id
     * @return \App\Entities\Role|null
     */
    public function findById(UuidInterface $id): ?Role
    {
        return $this->roleQuery->findById(id: $id);
    }

    /**
     * Finds a role by slug directly from the database.
     *
     * @param string $slug
     * @return \App\Entities\Role|null
     */
    public function findBySlug(string $slug): ?Role
    {
        return $this->roleQuery->findBySlug(slug: $slug);
    }

    /**
     * Saves a role and invalidates cache if necessary.
     *
     * @param \App\Entities\Role $role
     */
    public function save(Role $role): void
    {
        $this->roleTransaction->save(role: $role);

        if (Cache::has(key: self::CACHE_ROLE_ALL_KEY)) {
            Cache::forget(key: self::CACHE_ROLE_ALL_KEY);
        }
    }

    /**
     * Removes a role and invalidates cache if necessary.
     *
     * @param \App\Entities\Role $role
     */
    public function remove(Role $role): void
    {
        $this->roleTransaction->remove(role: $role);

        if (Cache::has(key: self::CACHE_ROLE_ALL_KEY)) {
            Cache::forget(key: self::CACHE_ROLE_ALL_KEY);
        }
    }
}
