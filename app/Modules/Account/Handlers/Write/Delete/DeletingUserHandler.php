<?php declare(strict_types=1);

namespace App\Modules\Account\Handlers\Write\Delete;

use App\Shared\Handler;
use App\Contracts\Interface\Repositories\UserRepositoryInterface;
use App\Modules\Account\Commands\DeleteAccountCommand;

final class DeletingUserHandler extends Handler
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {}

    public function handle(
        DeleteAccountCommand $command, \Closure $next): mixed
    {
        $user = $this->userRepository->findById(
            id: $command->id
        );

        if (!$user) {
            throw new \RuntimeException(
                message: "User with ID {$command->id} does not exist.",
                code: 404,
            );
        }

        $this->userRepository->remove(user: $user);

        return $next($command);
    }
}
