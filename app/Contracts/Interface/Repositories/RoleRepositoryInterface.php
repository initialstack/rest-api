<?php declare(strict_types=1);

namespace App\Contracts\Interface\Repositories;

use App\Entities\Role;

interface RoleRepositoryInterface
{
    /**
     * Saves a role to the repository.
     *
     * @param \App\Entities\Role $role
     */
    public function save(Role $role): void;

    /**
     * Removes a role from the repository.
     *
     * @param \App\Entities\Role $role
     */
    public function remove(Role $role): void;
}
