<?php declare(strict_types=1);

namespace App\Modules\Account\Handlers\Read;

use App\Shared\Handler;
use App\Contracts\Interface\Repositories\UserRepositoryInterface;
use App\Modules\Account\Queries\GetAllUsersQuery;

final class GetAllUsersQueryHandler extends Handler
{
    /**
     * User repository instance for accessing user data.
     */
    private UserRepositoryInterface $userRepository;

    /**
     * Constructs a new GetAllUsersQueryHandler instance.
     *
     * Initializes the user repository for handling queries.
     *
     * @param \App\Contracts\Interface\Repositories\UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Handles the GetAllUsersQuery by retrieving all users.
     *
     * @param \App\Modules\Account\Queries\GetAllUsersQuery $query
     * @return array
     */
    public function handle(GetAllUsersQuery $query): array
    {
        return $this->userRepository->all();
    }
}
