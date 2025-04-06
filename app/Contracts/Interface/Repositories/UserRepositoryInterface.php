<?php declare(strict_types=1);

namespace App\Contracts\Interface\Repositories;

use App\Entities\User;

interface UserRepositoryInterface
{
    /**
     * Saves a user to the repository.
     *
     * @param \App\Entities\User $user
     */
    public function save(User $user): void;

    /**
     * Removes a user from the repository.
     *
     * @param \App\Entities\User $user
     */
    public function remove(User $user): void;
}
