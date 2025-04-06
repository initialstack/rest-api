<?php declare(strict_types=1);

namespace App\Repositories\Storage\Queries;

use App\Entities\User;
use Doctrine\ORM\{EntityManagerInterface, ORMException};
use App\Contracts\Interface\Repositories\Storage\UserStorageRepositoryInterface;
use Ramsey\Uuid\UuidInterface;

final class UserQueryRepository implements UserStorageRepositoryInterface
{
    /**
     * Constructs a new UserQueryRepository instance.
     *
     * @param \Doctrine\ORM\EntityManagerInterface $entityManager
     */
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {}

    /**
     * Retrieves all users ordered by creation date in descending order.
     *
     * @return array
     */
    public function all(): array
    {
        return $this->entityManager->getRepository(
            className: User::class
        )->findBy(
            criteria: [],
            orderBy: ['createdAt' => 'DESC']
        );
    }

    /**
     * Finds a user by ID in the database.
     *
     * @param \Ramsey\Uuid\UuidInterface $id
     * @return \App\Entities\User|null
     */
    public function findById(UuidInterface $id): ?User
    {
        return $this->entityManager->getRepository(
            className: User::class
        )->find(
            id: $id
        );
    }

    /**
     * Finds a user by email in the database.
     *
     * @param string $email
     * @return \App\Entities\User|null
     */
    public function findByEmail(string $email): ?User
    {
        return $this->entityManager->getRepository(
            className: User::class
        )->findOneBy(
            criteria: ['email' => $email]
        );
    }

    /**
     * Saves a user to the database.
     *
     * @param \App\Entities\User $user
     */
    public function save(User $user): void
    {
        try {
            $this->entityManager->persist(object: $user);
            $this->entityManager->flush();
        }

        catch (ORMException $e) {
            Log::error(
                message: 'User creation failed: ' . $e->getMessage(),
                context: [
                    'code' => $e->getCode(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => $e->getTraceAsString()
                ]
            );

            throw new \RuntimeException(
                message: "Failed to save user: {$e->getMessage()}",
                code: (int) $e->getCode(),
                previous: $e
            );
        }
    }

    /**
     * Removes a user from the database.
     *
     * @param \App\Entities\User $user
     */
    public function remove(User $user): void
    {
        try {
            $this->entityManager->remove(object: $user);
            $this->entityManager->flush();
        }

        catch (ORMException $e) {
            Log::error(
                message: 'User deletion failed: ' . $e->getMessage(),
                context: [
                    'code' => $e->getCode(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => $e->getTraceAsString()
                ]
            );

            throw new \RuntimeException(
                message: "Failed to delete user: {$e->getMessage()}",
                code: (int) $e->getCode(),
                previous: $e
            );
        }
    }
}
