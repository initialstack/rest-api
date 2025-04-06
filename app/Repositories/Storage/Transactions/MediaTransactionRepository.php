<?php declare(strict_types=1);

namespace App\Repositories\Storage\Transactions;

use Illuminate\Support\Facades\{DB, Log};
use App\Contracts\Interface\Repositories\MediaRepositoryInterface;
use Illuminate\Database\QueryException;
use App\Repositories\Storage\Queries\MediaQueryRepository;
use App\Entities\Media;

final class MediaTransactionRepository implements MediaRepositoryInterface
{
	/**
     * The underlying media query repository for database operations.
     *
     * @var \App\Repositories\Storage\Queries\MediaQueryRepository
     */
    private MediaQueryRepository $mediaQuery;

    /**
     * Constructs a new MediaTransactionRepository instance.
     *
     * @param MediaQueryRepository $mediaQuery
     */
    public function __construct(MediaQueryRepository $mediaQuery)
    {
        $this->mediaQuery = $mediaQuery;
    }

    /**
     * Saves a media within a database transaction to ensure atomicity.
     *
     * @param \App\Entities\Media $media
     */
    public function save(Media $media): void
    {
        try {
            DB::transaction(
                callback: fn () => $this->mediaQuery->save(media: $media),
                attempts: 3
            );
        }

        catch (QueryException $e) {
            Log::error(
                message: 'Database Error: ' . $e->getMessage(),
                context: [
                    'code' => $e->getCode(),
                    'bindings' => $e->getBindings(),
                    'sql' => $e->getSql()
                ]
            );

            throw new \RuntimeException(
                message: 'Error Saving Media: ' . $e->getMessage(),
                code: (int) $e->getCode(),
                previous: $e
            );
        }
    }

    /**
     * Removes a media within a database transaction to ensure atomicity.
     *
     * @param \App\Entities\Media $media
     */
    public function remove(Media $media): void
    {
        try {
            DB::transaction(
                callback: fn () => $this->mediaQuery->remove(media: $media),
                attempts: 3
            );
        }

        catch (QueryException $e) {
            Log::error(
                message: 'Database Error: ' . $e->getMessage(),
                context: [
                    'code' => $e->getCode(),
                    'bindings' => $e->getBindings(),
                    'sql' => $e->getSql()
                ]
            );

            throw new \RuntimeException(
                message: 'Error Deleting Media: ' . $e->getMessage(),
                code: (int) $e->getCode(),
                previous: $e
            );
        }
    }
}
