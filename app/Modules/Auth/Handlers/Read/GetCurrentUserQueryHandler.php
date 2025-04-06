<?php declare(strict_types=1);

namespace App\Modules\Auth\Handlers\Read;

use App\Shared\Handler;
use App\Modules\Auth\Queries\GetCurrentUserQuery;
use App\Services\Authenticate;
use App\Entities\User;

final class GetCurrentUserQueryHandler extends Handler
{
    /**
     * Constructs a new GetCurrentUserQueryHandler instance.
     *
     * @param Authenticate $authenticate
     */
    public function __construct(
        private Authenticate $authenticate
    ) {}

    /**
     * Handles the get current user query by retrieving the current authenticated user.
     *
     * @param GetCurrentUserQuery $query
     * @return \App\Entities\User|null
     */
    public function handle(GetCurrentUserQuery $query): ?User
    {
        return $this->authenticate->getMe();
    }
}
