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
     * Initializes storage and memory repositories for media.
     *
     * @param MediaStorageRepositoryInterface $storageRepository
     * @param MediaMemoryRepositoryInterface $memoryRepository
     */
    protected function __construct(
        protected MediaStorageRepositoryInterface $storageRepository,
        protected MediaMemoryRepositoryInterface $memoryRepository
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
     * Retrieves all media from the storage repository.
     *
     * @return array
     */
    private function getAllMediaFromStorage(): array
    {
        return $this->storageRepository->all();
    }

    /**
     * Saves a collection of media to the memory repository.
     *
     * @param array $media
     */
    private function saveMediaToMemory(array $media): void
    {
        collect(value: $media)->each(
            callback: function (Media $media): void {
                $this->memoryRepository->save(media: $media);
            }
        );
    }

    /**
     * Initializes the memory repository if it is empty.
     */
    private function initializeMemoryRepository(): void
    {
        if ($this->isMemoryRepositoryEmpty()) {
            $media = $this->getAllMediaFromStorage();
            $this->saveMediaToMemory(media: $media);
        }
    }

    /**
     * Retrieves a collection of all media from the repository.
     *
     * @return \App\Entities\Media[]
     */
    abstract protected function all(): array;

    /**
     * Retrieves media by their ID.
     *
     * @param \Ramsey\Uuid\UuidInterface $id
     * @return \App\Entities\Media|null
     */
    abstract protected function findById(UuidInterface $id): ?Media;

    /**
     * Retrieves media associated with a specific entity ID.
     *
     * @param string $entityId
     * @return \App\Entities\Media[]
     */
    abstract protected function findByEntityId(string $entityId): array;
}
