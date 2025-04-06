<?php declare(strict_types=1);

namespace App\Modules\Auth\Handlers\Read;

use App\Shared\Handler;
use App\Modules\Auth\Queries\SignOutUserQuery;
use App\Services\Authenticate;

final class SignOutUserQueryHandler extends Handler
{
    /**
     * Constructs a new SignOutUserQueryHandler instance.
     *
     * @param Authenticate $authenticate
     */
    public function __construct(
        private Authenticate $authenticate
    ) {}

    /**
     * Handles the sign-out query by logging out the current user.
     *
     * @param SignOutUserQuery $query
     * @return bool
     */
    public function handle(SignOutUserQuery $query): bool
    {
        try {
            $this->authenticate->logout();
            return true;
        } catch (\Throwable $e) {
            return false;
        }
    }
}
