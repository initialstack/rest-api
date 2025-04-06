<?php declare(strict_types=1);

namespace App\Repositories\Memory;

use Ramsey\Uuid\UuidInterface;
use App\Contracts\Interface\Repositories\Memory\UserMemoryRepositoryInterface;
use App\Entities\User;

final class UserMemoryRepository implements UserMemoryRepositoryInterface
{
    /**
     * The in-memory collection of users.
     *
     * @var array
     */
    private array $collection;

    /**
     * Constructs a new UserMemoryRepository instance.
     *
     * @param array $users
     */
    public function __construct(array $users = [])
    {
        $this->collection = $users;
    }

    /**
     * Retrieves all users from the in-memory collection.
     *
     * @return array
     */
    public function all(): array
    {
        return array_values(array: $this->collection);
    }

    /**
     * Finds a user by ID in the in-memory collection.
     *
     * @param \Ramsey\Uuid\UuidInterface $id
     * @return \App\Entities\User|null
     */
    public function findById(UuidInterface $id): ?User
    {
        return $this->collection[$id->toString()] ?? null;
    }

    /**
     * Finds a user by email in the in-memory collection.
     *
     * @param string $email
     * @return \App\Entities\User|null
     */
    public function findByEmail(string $email): ?User
    {
        return $this->collection[$email] ?? null;
    }

    /**
     * Saves a user to the in-memory collection.
     *
     * @param \App\Entities\User $user
     */
    public function save(User $user): void
    {
        $this->collection[] = $user;
    }

    /**
     * Removes a user from the in-memory collection.
     *
     * @param \App\Entities\User $user
     */
    public function remove(User $user): void
    {
        unset($this->collection[$user->getId()->toString()]);
    }
}
