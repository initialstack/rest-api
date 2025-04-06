<?php declare(strict_types=1);

namespace App\Repositories;

use Ramsey\Uuid\UuidInterface;
use App\Contracts\Interface\Repositories\Storage\UserStorageRepositoryInterface;
use App\Contracts\Interface\Repositories\Memory\UserMemoryRepositoryInterface;
use App\Contracts\Abstract\UserRepositoryAbstract;
use App\Entities\User;

final class UserRepository extends UserRepositoryAbstract
{
    /**
     * Constructs a new UserRepository instance.
     *
     * @param UserStorageRepositoryInterface $storageRepository
     * @param UserMemoryRepositoryInterface $memoryRepository
     */
    public function __construct(
        protected UserStorageRepositoryInterface $storageRepository,
        protected UserMemoryRepositoryInterface $memoryRepository
    ) {
        /*
         * Call the parent constructor to initialize base functionality.
         */
        parent::__construct(
            storageRepository: $storageRepository,
            memoryRepository: $memoryRepository
        );
    }

    /**
     * Retrieves all users, first checking the memory cache and then the storage if necessary.
     *
     * @return array
     */
    public function all(): array
    {
        $memory = $this->memoryRepository->all();

        if (!empty($memory)) {
            return $memory;
        }

        $storage = $this->storageRepository->all();

        return $storage;
    }

    /**
     * Finds a user by ID, checking memory cache first and then storage if necessary.
     *
     * @param \Ramsey\Uuid\UuidInterface $id
     * @return \App\Entities\User|null
     */
    public function findById(UuidInterface $id): ?User
    {
        $memory = $this->memoryRepository->findById(id: $id);

        if ($memory !== null) {
            return $memory;
        }

        $storage = $this->storageRepository->findById(id: $id);

        return $storage;
    }

    /**
     * Finds a user by email, checking memory cache first and then storage if necessary.
     *
     * @param string $email
     * @return \App\Entities\User|null
     */
    public function findByEmail(string $email): ?User
    {
        $memory = $this->memoryRepository->findByEmail(email: $email);

        if ($memory !== null) {
            return $memory;
        }

        $storage = $this->storageRepository->findByEmail(email: $email);
        
        return $storage;
    }

    /**
     * Saves a user to both memory and storage repositories.
     *
     * @param \App\Entities\User $user
     */
    public function save(User $user): void
    {
        $this->memoryRepository->save(user: $user);
        $this->storageRepository->save(user: $user);
    }

    /**
     * Removes a user from both memory and storage repositories.
     *
     * @param \App\Entities\User $user
     */
    public function remove(User $user): void
    {
        $this->memoryRepository->remove(user: $user);
        $this->storageRepository->remove(user: $user);
    }
}
