<?php declare(strict_types=1);

namespace App\Repositories\Memory;

use Ramsey\Uuid\UuidInterface;
use App\Contracts\Interface\Repositories\Memory\MediaMemoryRepositoryInterface;
use App\Entities\Media;

final class MediaMemoryRepository implements MediaMemoryRepositoryInterface
{
    /**
     * The in-memory collection of media.
     *
     * @var array
     */
    private array $collection;

    /**
     * Constructs a new MediaMemoryRepository instance.
     *
     * @param array $media
     */
    public function __construct(array $media = [])
    {
        $this->collection = $media;
    }

    /**
     * Retrieves all media from the in-memory collection.
     *
     * @return array
     */
    public function all(): array
    {
        return array_values(array: $this->collection);
    }

    /**
     * Finds a media by ID in the in-memory collection.
     *
     * @param \Ramsey\Uuid\UuidInterface $id
     * @return \App\Entities\Media|null
     */
    public function findById(UuidInterface $id): ?Media
    {
        return $this->collection[$id->toString()] ?? null;
    }

    /**
     * Finds media by entity ID in the in-memory collection.
     *
     * @param string $entityId
     * @return array
     */
    public function findByEntityId(string $entityId): array
    {
        $matching = array_filter(
            array: $this->collection,
            callback: function (Media $media) use ($entityId): bool {
                return $media->getEntityId() === $entityId;
            }
        );

        return array_values(array: $matching);
    }

    /**
     * Saves a media to the in-memory collection.
     *
     * @param \App\Entities\Media $media
     */
    public function save(Media $media): void
    {
        $this->collection[] = $media;
    }

    /**
     * Removes a media from the in-memory collection.
     *
     * @param \App\Entities\Media $media
     */
    public function remove(Media $media): void
    {
        unset($this->collection[$media->getId()->toString()]);
    }
}
