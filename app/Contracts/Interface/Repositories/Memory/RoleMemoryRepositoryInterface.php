<?php declare(strict_types=1);

namespace App\Contracts\Interface\Repositories\Memory;

use Ramsey\Uuid\UuidInterface;
use App\Contracts\Interface\Repositories\RoleRepositoryInterface;
use App\Entities\Role;

interface RoleMemoryRepositoryInterface extends RoleRepositoryInterface
{
    /**
     * Retrieves all roles.
     *
     * @return \App\Entities\Role[]
     */
    public function all(): array;

    /**
     * Retrieves a role by their ID.
     *
     * @param \Ramsey\Uuid\UuidInterface $id
     * @return \App\Entities\Role|null
     */
    public function findById(UuidInterface $id): ?Role;

    /**
     * Retrieves a role by their slug.
     *
     * @param string $slug
     * @return \App\Entities\Role|null
     */
    public function findBySlug(string $slug): ?Role;
}
