<?php declare(strict_types=1);

namespace App\Contracts\Interface\Repositories;

use App\Entities\Media;

interface MediaRepositoryInterface
{
    /**
     * Saves media to the repository.
     *
     * @param \App\Entities\Media $media
     */
    public function save(Media $media): void;

    /**
     * Removes media from the repository.
     *
     * @param \App\Entities\Media $media
     */
    public function remove(Media $media): void;
}
