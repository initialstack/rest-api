<?php declare(strict_types=1);

namespace App\Modules\Auth\Handlers\Write;

use App\Shared\Handler;
use App\Modules\Auth\Commands\RegisterCommand;
use App\Contracts\Interface\Repositories\UserRepositoryInterface;
use App\Contracts\Interface\Repositories\RoleRepositoryInterface;
use App\Entities\User;

final class RegisterHandler extends Handler
{
    /**
     * Constructs a new RegisterHandler instance.
     *
     * @param UserRepositoryInterface $userRepository
     * @param UserRepositoryInterface $roleRepository
     */
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private RoleRepositoryInterface $roleRepository,
    ) {}

    /**
     * Handles the register command by creating a new user.
     *
     * @param RegisterCommand $command
     * @return bool
     */
    public function handle(RegisterCommand $command): bool
    {
        $user = new User(
            firstName: $command->firstName,
            lastName: $command->lastName,
            email: $command->email,
            password: $command->password,
        );

        $role = $this->roleRepository->findBySlug(slug: 'user');

        $user->setRole(role: $role);

        $this->userRepository->save(user: $user);

        return $user ? true : false;
    }
}
