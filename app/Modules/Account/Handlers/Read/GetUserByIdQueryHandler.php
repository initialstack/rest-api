<?php declare(strict_types=1);

namespace App\Modules\Account\Handlers\Read;

use App\Shared\Handler;
use App\Modules\Account\Queries\GetUserByIdQuery;
use App\Contracts\Interface\Repositories\UserRepositoryInterface;
use App\Entities\User;

final class GetUserByIdQueryHandler extends Handler
{
    /**
     * User repository instance for accessing user data.
     */
    private readonly UserRepositoryInterface $userRepository;

    /**
     * Constructs a new GetUserByIdQueryHandler instance.
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
     * Handles the GetUserByIdQuery by retrieving a user by their ID.
     *
     * @param \App\Modules\Account\Queries\GetUserByIdQuery $query
     * @return \App\Entities\User|null
     */
    public function handle(GetUserByIdQuery $query): ?User
    {
        return $this->userRepository->findById(id: $query->getId());
    }
}
