<?php declare(strict_types=1);

namespace App\Contracts\Abstract;

use Ramsey\Uuid\UuidInterface;
use App\Contracts\Interface\Repositories\MediaRepositoryInterface;
use App\Contracts\Interface\Repositories\Storage\MediaStorageRepositoryInterface;
use App\Contracts\Interface\Repositories\Memory\MediaMemoryRepositoryInterface;
use App\Entities\Media;

abstract class MediaRepositoryAbstract implements MediaRepositoryInterface
{
    /**
     * Constructs a new MediaRepositoryAbstract instance.
     *
     * Initializes the storage and memory repositories for media management.
     *
     * @param \App\Contracts\Interface\Repositories\Storage\MediaStorageRepositoryInterface $storageRepository
     * @param \App\Contracts\Interface\Repositories\Memory\MediaMemoryRepositoryInterface $memoryRepository
     */
    protected function __construct(
        protected MediaStorageRepositoryInterface $storageRepository,
        protected MediaMemoryRepositoryInterface $memoryRepository
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

            // Save each media item from the storage repository into the memory repository.
            $collection->each(callback: function(Media $media): void {
                $this->memoryRepository->save(media: $media);
            });
        }
    }

    /**
     * Retrieves all media.
     *
     * Must be implemented by child classes.
     *
     * @return \App\Entities\Media[]
     */
    abstract protected function all(): array;

    /**
     * Retrieves media by their ID.
     *
     * Must be implemented by child classes.
     *
     * @param \Ramsey\Uuid\UuidInterface $id
     * @return \App\Entities\Media|null
     */
    abstract protected function findById(UuidInterface $id): ?Media;

    /**
     * Retrieves media associated with a specific entity ID.
     *
     * Must be implemented by child classes.
     *
     * @param string $entityId
     * @return \App\Entities\Media[]
     */
    abstract protected function findByEntityId(string $entityId): array;
}
