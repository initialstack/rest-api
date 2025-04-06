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
     * Initializes the storage and memory repositories for user management.
     *
     * @param \App\Contracts\Interface\Repositories\Storage\UserStorageRepositoryInterface $storageRepository
     * @param \App\Contracts\Interface\Repositories\Memory\UserMemoryRepositoryInterface $memoryRepository
     */
    protected function __construct(
        protected UserStorageRepositoryInterface $storageRepository,
        protected UserMemoryRepositoryInterface $memoryRepository
    ) {
        $this->initializeMemoryRepository();
    }

    /**
     * Initializes the memory repository by populating it from the storage repository if it is empty.
     */
    protected function initializeMemoryRepository(): void
    {
        // If the memory repository is empty, populate it from the storage repository.
        if (count(value: $this->memoryRepository->all()) === 0) {
            $collection = collect(value: $this->storageRepository->all());

            // Save each user from the storage repository into the memory repository.
            $collection->each(callback: function(User $user): void {
                $this->memoryRepository->save(user: $user);
            });
        }
    }

    /**
     * Retrieves all users.
     *
     * Must be implemented by child classes.
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
     * Must be implemented by child classes.
     *
     * @param string $email
     * @return \App\Entities\User|null
     */
    abstract protected function findByEmail(string $email): ?User;
}
