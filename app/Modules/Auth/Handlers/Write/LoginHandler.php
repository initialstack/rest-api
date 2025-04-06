<?php declare(strict_types=1);

namespace App\Modules\Auth\Handlers\Write;

use App\Shared\Handler;
use App\Modules\Auth\Commands\LoginCommand;
use Illuminate\Support\Facades\Auth;
use App\Services\Authenticate;

final class LoginHandler extends Handler
{
    /**
     * @var \App\Services\Authenticate
     */
    private readonly Authenticate $authenticate;

    /**
     * Injects the Authenticate service
     *
     * @param \App\Services\Authenticate $authenticate
     */
    public function __construct(Authenticate $authenticate)
    {
        $this->authenticate = $authenticate;
    }

    /**
     * Handle the login command.
     *
     * @param \App\Modules\Auth\Commands\LoginCommand $command
     * @return string|null
     */
    public function handle(LoginCommand $command): ?string
    {
        $user = $this->authenticate->retrieveByCredentials(
            credentials: $command->toArray()
        );

        if (!$user) {
            return null;
        }

        $validate = $this->authenticate->validateCredentials(
            user: $user,
            credentials: $command->toArray()
        );

        if (!$validate) {
            return null;
        }

        $this->authenticate->rehashPasswordIfRequired(
            user: $user,
            credentials: $command->toArray()
        );

        $rememberToken = bin2hex(string: random_bytes(30));

        $this->authenticate->updateRememberToken(
            user: $user,
            token: $rememberToken
        );

        $token = $this->authenticate->generateToken(
            user: $user
        );

        return $token;
    }
}
