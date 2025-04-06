<?php declare(strict_types=1);

namespace App\Modules\Account\Handlers\Write\Update;

use App\Shared\Handler;
use App\Contracts\Interface\Repositories\UserRepositoryInterface;
use App\Modules\Account\Commands\UpdateAccountCommand;

final class UpdatingUserHandler extends Handler
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {}

    public function handle(
        UpdateAccountCommand $command, \Closure $next): mixed
    {
        $user = $this->userRepository->findById(id: $command->id);

        if (!$user) {
            throw new \RuntimeException(
                message: "User with ID {$command->id} does not exist.",
                code: 404,
            );
        }

        $user->setFirstName(firstName: $command->firstName);
        $user->setLastName(lastName: $command->lastName);

        if (!empty($command->patronymic)) {
            $user->setPatronymic(patronymic: $command->patronymic);
        }

        $user->setEmail(email: $command->email);

        if (!empty($command->phone)) {
            $user->setPhone(phone: $command->phone);
        }

        $user->setPassword(password: $command->password);

        if (!empty($command->status)) {
            $user->setStatus(status: $command->status);
        }

        $this->userRepository->save(user: $user);

        return $next($command);
    }
}
