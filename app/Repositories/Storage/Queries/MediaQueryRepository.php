<?php declare(strict_types=1);

namespace App\Repositories\Storage\Queries;

use App\Entities\Media;
use App\Contracts\Interface\Repositories\Storage\MediaStorageRepositoryInterface;
use Doctrine\ORM\{EntityManagerInterface, ORMException};
use Ramsey\Uuid\UuidInterface;

final class MediaQueryRepository implements MediaStorageRepositoryInterface
{
    private EntityManagerInterface $entityManager;

    /**
     * Constructs a new MediaQueryRepository instance.
     *
     * @param Doctrine\ORM\EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Retrieves all media from the database, ordered by creation date in descending order.
     *
     * @return array
     */
    public function all(): array
    {
        return $this->entityManager->getRepository(
            className: Media::class
        )->findBy(
            criteria: [],
            orderBy: ['createdAt' => 'DESC']
        );
    }

    /**
     * Finds a media by ID in the database.
     *
     * @param \Ramsey\Uuid\UuidInterface $id
     * @return \App\Entities\Media|null
     */
    public function findById(UuidInterface $id): ?Media
    {
        return $this->entityManager->getRepository(
            className: Media::class
        )->find(
            id: $id
        );
    }

    /**
     * Finds media by entity ID in the database, ordered by creation date in descending order.
     *
     * @param string $entityId
     * @return array
     */
    public function findByEntityId(string $entityId): array
    {
        return $this->entityManager->getRepository(
            className: Media::class
        )->findBy(
            criteria: ['entityId' => $entityId],
            orderBy: ['createdAt' => 'DESC']
        );
    }

    /**
     * Saves a media to the database.
     *
     * @param \App\Entities\Media $media
     */
    public function save(Media $media): void
    {
        try {
            $this->entityManager->persist(object: $media);
            $this->entityManager->flush();
        }

        catch (ORMException $e) {
            Log::error(
                message: 'Media creation failed: ' . $e->getMessage(),
                context: [
                    'code' => $e->getCode(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => $e->getTraceAsString()
                ]
            );

            throw new \RuntimeException(
                message: "Failed to save media: {$e->getMessage()}",
                code: (int) $e->getCode(),
                previous: $e
            );
        }
    }

    /**
     * Removes a media from the database.
     *
     * @param \App\Entities\Media $media
     */
    public function remove(Media $media): void
    {
        try {
            $this->entityManager->remove(object: $media);
            $this->entityManager->flush();
        }

        catch (ORMException $e) {
            Log::error(
                message: 'Media deletion failed: ' . $e->getMessage(),
                context: [
                    'code' => $e->getCode(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => $e->getTraceAsString()
                ]
            );

            throw new \RuntimeException(
                message: "Failed to delete media: {$e->getMessage()}",
                code: (int) $e->getCode(),
                previous: $e
            );
        }
    }
}
