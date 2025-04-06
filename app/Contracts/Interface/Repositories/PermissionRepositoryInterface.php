<?php declare(strict_types=1);

namespace App\Contracts\Interface\Repositories;

use App\Entities\Permission;

interface PermissionRepositoryInterface
{
    /**
     * Saves a permission to the repository.
     *
     * @param \App\Entities\Permission $permission
     */
    public function save(Permission $permission): void;

    /**
     * Removes a permission from the repository.
     *
     * @param \App\Entities\Permission $permission
     */
    public function remove(Permission $permission): void;
}
