<?php declare(strict_types=1);

namespace App\Repositories\Storage\Queries;

use App\Entities\Permission;
use Doctrine\ORM\{EntityManagerInterface, ORMException};
use App\Contracts\Interface\Repositories\Storage\PermissionStorageRepositoryInterface;
use Ramsey\Uuid\UuidInterface;

final class PermissionQueryRepository implements PermissionStorageRepositoryInterface
{
    /**
     * Constructs a new PermissionQueryRepository instance.
     *
     * @param \Doctrine\ORM\EntityManagerInterface $entityManager
     */
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {}

    /**
     * Retrieves all permissions ordered by creation date in descending order.
     *
     * @return array
     */
    public function all(): array
    {
        return $this->entityManager->getRepository(
            className: Permission::class
        )->findBy(
            criteria: [],
            orderBy: ['createdAt' => 'DESC']
        );
    }

    /**
     * Finds a permission by ID in the database.
     *
     * @param \Ramsey\Uuid\UuidInterface $id
     * @return \App\Entities\Permission|null
     */
    public function findById(UuidInterface $id): ?Permission
    {
        return $this->entityManager->getRepository(
            className: Permission::class
        )->find(
            id: $id
        );
    }

    /**
     * Finds a permission by slug in the database.
     *
     * @param string $slug
     * @return \App\Entities\Permission|null
     */
    public function findBySlug(string $slug): ?Permission
    {
        return $this->entityManager->getRepository(
            className: Permission::class
        )->findOneBy(
            criteria: ['slug' => $slug]
        );
    }

    /**
     * Saves a permission to the database.
     *
     * @param \App\Entities\Permission $permission
     */
    public function save(Permission $permission): void
    {
        try {
            $this->entityManager->persist(object: $permission);
            $this->entityManager->flush();
        }

        catch (ORMException $e) {
            Log::error(
                message: 'Permission creation failed: ' . $e->getMessage(),
                context: [
                    'code' => $e->getCode(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => $e->getTraceAsString()
                ]
            );

            throw new \RuntimeException(
                message: "Failed to save permission: {$e->getMessage()}",
                code: (int) $e->getCode(),
                previous: $e
            );
        }
    }

    /**
     * Removes a permission from the database.
     *
     * @param \App\Entities\Permission $permission
     */
    public function remove(Permission $permission): void
    {
        try {
            $this->entityManager->remove(object: $permission);
            $this->entityManager->flush();
        }

        catch (ORMException $e) {
            Log::error(
                message: 'Permission deletion failed: ' . $e->getMessage(),
                context: [
                    'code' => $e->getCode(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => $e->getTraceAsString()
                ]
            );

            throw new \RuntimeException(
                message: "Failed to delete permission: {$e->getMessage()}",
                code: (int) $e->getCode(),
                previous: $e
            );
        }
    }
}
