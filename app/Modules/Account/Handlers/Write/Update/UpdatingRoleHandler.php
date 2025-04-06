<?php declare(strict_types=1);

namespace App\Modules\Account\Handlers\Write\Update;

use App\Shared\Handler;
use App\Contracts\Interface\Repositories\UserRepositoryInterface;
use App\Contracts\Interface\Repositories\RoleRepositoryInterface;
use App\Modules\Account\Commands\UpdateAccountCommand;

final class UpdatingRoleHandler extends Handler
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private RoleRepositoryInterface $roleRepository,
    ) {}

    public function handle(
        UpdateAccountCommand $command, \Closure $next): mixed
    {
        if (!empty($command->roleId)) {
            $role = $this->roleRepository->findById(id: $command->roleId);

            if (!$role) {
                throw new \RuntimeException(
                    message: "Role with ID {$command->roleId} does not exist.",
                    code: 404,
                );
            }
            
            $user = $this->userRepository->findById(id: $command->id);

            $user->setRole(role: $role);

            $this->userRepository->save(user: $user);
        }

        return $next($command);
    }
}
