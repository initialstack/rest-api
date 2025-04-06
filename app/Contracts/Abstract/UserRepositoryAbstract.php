<?php declare(strict_types=1);

namespace App\Contracts\Abstract;

use Ramsey\Uuid\UuidInterface;
use App\Contracts\Interface\Repositories\UserRepositoryInterface;
use App\Contracts\Interface\Repositories\Storage\UserStorageRepositoryInterface;
use App\Contracts\Interface\Repositories\Memory\UserMemoryRepositoryInterface;
use App\Entities\User;

abstract class UserRepositoryAbstract implements UserRepositoryInterface
{
    /**
     * Constructs a new UserRepositoryAbstract instance.
     *
     * Initializes storage and memory repositories for users.
     *
     * @param UserStorageRepositoryInterface $storageRepository
     * @param UserMemoryRepositoryInterface $memoryRepository
     */
    protected function __construct(
        protected UserStorageRepositoryInterface $storageRepository,
        protected UserMemoryRepositoryInterface $memoryRepository
    ) {
        $this->initializeMemoryRepository();
    }

    /**
     * Checks if the memory repository is empty.
     *
     * @return bool
     */
    private function isMemoryRepositoryEmpty(): bool
    {
        return count(value: $this->memoryRepository->all()) === 0;
    }

    /**
     * Retrieves all users from the storage repository.
     *
     * @return array
     */
    private function getAllUsersFromStorage(): array
    {
        return $this->storageRepository->all();
    }

    /**
     * Saves a collection of users to the memory repository.
     *
     * @param array $users
     */
    private function saveUsersToMemory(array $users): void
    {
        collect(value: $users)->each(
            callback: function (User $user): void {
                $this->memoryRepository->save(user: $user);
            }
        );
    }

    /**
     * Initializes the memory repository if it is empty.
     */
    private function initializeMemoryRepository(): void
    {
        if ($this->isMemoryRepositoryEmpty()) {
            $users = $this->getAllUsersFromStorage();
            $this->saveUsersToMemory(users: $users);
        }
    }

    /**
     * Retrieves a collection of all users from the repository.
     *
     * @return \App\Entities\User[]
     */
    abstract protected function all(): array;

    /**
     * Retrieves a user by their ID.
     *
     * Must be implemented by child classes.
     *
     * @param \Ramsey\Uuid\UuidInterface $id
     * @return \App\Entities\User|null
     */
    abstract protected function findById(UuidInterface $id): ?User;

    /**
     * Retrieves a user by their email.
     *
     * @param string $email
     * @return \App\Entities\User|null
     */
    abstract protected function findByEmail(string $email): ?User;
}
