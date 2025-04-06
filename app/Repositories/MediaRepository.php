<?php declare(strict_types=1);

namespace App\Repositories;

use Ramsey\Uuid\UuidInterface;
use App\Contracts\Interface\Repositories\Storage\MediaStorageRepositoryInterface;
use App\Contracts\Interface\Repositories\Memory\MediaMemoryRepositoryInterface;
use App\Contracts\Abstract\MediaRepositoryAbstract;
use App\Entities\Media;

final class MediaRepository extends MediaRepositoryAbstract
{
    /**
     * Constructs a new MediaRepository instance.
     *
     * @param \App\Contracts\Interface\Repositories\Storage\MediaStorageRepositoryInterface $storageRepository
     * @param \App\Contracts\Interface\Repositories\Memory\MediaMemoryRepositoryInterface $memoryRepository
     */
    public function __construct(
        protected MediaStorageRepositoryInterface $storageRepository,
        protected MediaMemoryRepositoryInterface $memoryRepository
    ) {
        parent::__construct(
            storageRepository: $storageRepository,
            memoryRepository: $memoryRepository
        );
    }

    /**
     * Retrieves all media, first checking the memory cache and then the storage if necessary.
     *
     * @return array
     */
    public function all(): array
    {
        $memory = $this->memoryRepository->all();

        if (!empty($memory)) {
            return $memory;
        }

        $cached = $this->storageRepository->all();

        return $cached;
    }

    /**
     * Finds a media by ID, checking memory cache first and then storage if necessary.
     *
     * @param \Ramsey\Uuid\UuidInterface $id
     * @return \App\Entities\Media|null
     */
    public function findById(UuidInterface $id): ?Media
    {
        $memory = $this->memoryRepository->findById(id: $id);

        if ($memory !== null) {
            return $memory;
        }

        $cached = $this->storageRepository->findById(id: $id);

        return $cached;
    }

    /**
     * Finds media by entity ID, checking memory cache first and then storage if necessary.
     *
     * @param string $entityId
     * @return array
     */
    public function findByEntityId(string $entityId): array
    {
        $memory = $this->memoryRepository->findByEntityId(
            entityId: $entityId
        );

        if ($memory !== null) {
            return $memory;
        }
        
        $cached = $this->storageRepository->findByEntityId(
            entityId: $entityId
        );
        
        return $cached;
    }

    /**
     * Saves a media to both memory and storage repositories.
     *
     * @param \App\Entities\Media $media
     */
    public function save(Media $media): void
    {
        $this->memoryRepository->save(media: $media);
        $this->storageRepository->save(media: $media);
    }

    /**
     * Removes a media from both memory and storage repositories.
     *
     * @param \App\Entities\Media $media
     */
    public function remove(Media $media): void
    {
        $this->memoryRepository->remove(media: $media);
        $this->storageRepository->remove(media: $media);
    }
}
