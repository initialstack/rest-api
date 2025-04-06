<?php declare(strict_types=1);

namespace App\Contracts\Interface\Repositories\Memory;

use App\Contracts\Interface\Repositories\UserRepositoryInterface;

use Ramsey\Uuid\UuidInterface;
use App\Entities\User;

interface UserMemoryRepositoryInterface extends UserRepositoryInterface
{
    /**
     * Retrieves all users.
     *
     * @return \App\Entities\User[]
     */
    public function all(): array;

    /**
     * Retrieves a user by their ID.
     *
     * @param \Ramsey\Uuid\UuidInterface $id
     * @return \App\Entities\User|null
     */
    public function findById(UuidInterface $id): ?User;

    /**
     * Retrieves a user by their email.
     *
     * @param string $email
     * @return \App\Entities\User|null
     */
    public function findByEmail(string $email): ?User;
}
