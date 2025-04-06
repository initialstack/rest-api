<?php declare(strict_types=1);

namespace App\Modules\Account\Handlers\Write\Create;

use App\Shared\Handler;
use App\Contracts\Interface\Repositories\RoleRepositoryInterface;
use App\Contracts\Interface\Repositories\UserRepositoryInterface;
use App\Modules\Account\Commands\CreateAccountCommand;
use App\Entities\{User, Role};

final class AssigningRoleHandler extends Handler
{
    public function __construct(
        private RoleRepositoryInterface $roleRepository,
        private UserRepositoryInterface $userRepository
    ) {}

    public function handle(
        CreateAccountCommand $command, \Closure $next): mixed
    {
        if (!$command->userId) {
            throw new \RuntimeException(
                message: "User ID is not provided.",
                code: 400,
            );
        }

        $user = $this->userRepository->findById(id: $command->userId);

        if (!$user) {
            throw new \RuntimeException(
                message: "User with ID {$command->userId} does not exist.",
                code: 404,
            );
        }

        if (!empty($command->roleId)) {
            $role = $this->roleRepository->findById(id: $command->roleId);

            if (!$role) {
                throw new \RuntimeException(
                    message: "Role with ID {$command->roleId} does not exist.",
                    code: 404,
                );
            }

            $user->setRole(role: $role);

            $this->userRepository->save(user: $user);
        }

        return $next($command);
    }
}
