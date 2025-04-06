<?php declare(strict_types=1);

namespace App\Contracts\Interface\Repositories\Storage;

use Ramsey\Uuid\UuidInterface;
use App\Contracts\Interface\Repositories\PermissionRepositoryInterface;
use App\Entities\Permission;

interface PermissionStorageRepositoryInterface extends PermissionRepositoryInterface
{
    /**
     * Retrieves all permissions.
     *
     * @return \App\Entities\Permission[]
     */
    public function all(): array;

    /**
     * Retrieves a permission by their ID.
     *
     * @param \Ramsey\Uuid\UuidInterface $id
     * @return \App\Entities\Permission|null
     */
    public function findById(UuidInterface $id): ?Permission;

    /**
     * Retrieves a permission by their slug.
     *
     * @param string $slug
     * @return \App\Entities\Permission|null
     */
    public function findBySlug(string $slug): ?Permission;
}
