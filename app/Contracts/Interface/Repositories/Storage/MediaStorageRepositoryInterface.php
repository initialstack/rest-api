<?php declare(strict_types=1);

namespace App\Contracts\Interface\Repositories\Storage;

use Ramsey\Uuid\UuidInterface;
use App\Contracts\Interface\Repositories\MediaRepositoryInterface;
use App\Entities\Media;

interface MediaStorageRepositoryInterface extends MediaRepositoryInterface
{
    /**
     * Retrieves all media.
     *
     * @return \App\Entities\Media[]
     */
    public function all(): array;

    /**
     * Retrieves media by their ID.
     *
     * @param \Ramsey\Uuid\UuidInterface $id
     * @return \App\Entities\Media|null
     */
    public function findById(UuidInterface $id): ?Media;

    /**
     * Retrieves media associated with a specific entity ID.
     *
     * @param string $entityId
     * @return \App\Entities\Media[]
     */
    public function findByEntityId(string $entityId): array;
}
