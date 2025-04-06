<?php declare(strict_types=1);

namespace App\Repositories\Storage\Transactions;

use Illuminate\Support\Facades\{DB, Log};
use App\Contracts\Interface\Repositories\UserRepositoryInterface;
use Illuminate\Database\QueryException;
use App\Repositories\Storage\Queries\UserQueryRepository;
use App\Entities\User;

final class UserTransactionRepository implements UserRepositoryInterface
{
	/**
     * The underlying user query repository for database operations.
     *
     * @var \App\Contracts\Interface\Repositories\UserRepositoryInterface
     */
    private UserQueryRepository $userQuery;

    /**
     * Constructs a new UserTransactionRepository instance.
     *
     * @param UserQueryRepository $userQuery
     */
    public function __construct(UserQueryRepository $userQuery)
    {
        $this->userQuery = $userQuery;
    }

    /**
     * Saves a user within a database transaction to ensure atomicity.
     *
     * @param \App\Entities\User $user
     */
    public function save(User $user): void
    {
        try {
            DB::transaction(
                callback: fn () => $this->userQuery->save(user: $user),
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
                message: 'Error Saving User: ' . $e->getMessage(),
                code: (int) $e->getCode(),
                previous: $e
            );
        }
    }

    /**
     * Removes a user within a database transaction to ensure atomicity.
     *
     * @param \App\Entities\User $user
     */
    public function remove(User $user): void
    {
        try {
            DB::transaction(
                callback: fn () => $this->userQuery->remove(user: $user),
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
                message: 'Error Deleting User: ' . $e->getMessage(),
                code: (int) $e->getCode(),
                previous: $e
            );
        }
    }
}
