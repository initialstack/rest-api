<?php declare(strict_types=1);

namespace App\Repositories\Storage\Queries;

use App\Entities\Role;
use Doctrine\ORM\{EntityManagerInterface, ORMException};
use App\Contracts\Interface\Repositories\Storage\RoleStorageRepositoryInterface;
use Ramsey\Uuid\UuidInterface;

final class RoleQueryRepository implements RoleStorageRepositoryInterface
{
    /**
     * Constructs a new RoleQueryRepository instance.
     *
     * @param \Doctrine\ORM\EntityManagerInterface $entityManager
     */
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {}

    /**
     * Retrieves all roles ordered by creation date in descending order.
     *
     * @return array
     */
    public function all(): array
    {
        return $this->entityManager->getRepository(
            className: Role::class
        )->findBy(
            criteria: [],
            orderBy: ['createdAt' => 'DESC']
        );
    }

    /**
     * Finds a role by ID in the database.
     *
     * @param \Ramsey\Uuid\UuidInterface $id
     * @return \App\Entities\Role|null
     */
    public function findById(UuidInterface $id): ?Role
    {
        return $this->entityManager->getRepository(
            className: Role::class
        )->find(
            id: $id
        );
    }

    /**
     * Finds a role by slug in the database.
     *
     * @param string $slug
     * @return \App\Entities\Role|null
     */
    public function findBySlug(string $slug): ?Role
    {
        return $this->entityManager->getRepository(
            className: Role::class
        )->findOneBy(
            criteria: ['slug' => $slug]
        );
    }

    /**
     * Saves a role to the database.
     *
     * @param \App\Entities\Role $role
     */
    public function save(Role $role): void
    {
        try {
            $this->entityManager->persist(object: $role);
            $this->entityManager->flush();
        }

        catch (ORMException $e) {
            Log::error(
                message: 'Role creation failed: ' . $e->getMessage(),
                context: [
                    'code' => $e->getCode(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => $e->getTraceAsString()
                ]
            );

            throw new \RuntimeException(
                message: "Failed to save role: {$e->getMessage()}",
                code: (int) $e->getCode(),
                previous: $e
            );
        }
    }

    /**
     * Removes a role from the database.
     *
     * @param \App\Entities\Role $role
     */
    public function remove(Role $role): void
    {
        try {
            $this->entityManager->remove(object: $role);
            $this->entityManager->flush();
        }

        catch (ORMException $e) {
            Log::error(
                message: 'Role deletion failed: ' . $e->getMessage(),
                context: [
                    'code' => $e->getCode(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => $e->getTraceAsString()
                ]
            );

            throw new \RuntimeException(
                message: "Failed to delete role: {$e->getMessage()}",
                code: (int) $e->getCode(),
                previous: $e
            );
        }
    }
}
