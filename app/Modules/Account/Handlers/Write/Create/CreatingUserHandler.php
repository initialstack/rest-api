<?php declare(strict_types=1);

namespace App\Modules\Account\Handlers\Write\Create;

use App\Shared\Handler;
use App\Modules\Account\Commands\CreateAccountCommand;
use App\Contracts\Interface\Repositories\UserRepositoryInterface;
use App\Entities\User;

final class CreatingUserHandler extends Handler
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
    ) {}

    public function handle(
        CreateAccountCommand $command, \Closure $next): mixed
    {
        $user = new User(
            firstName: $command->firstName,
            lastName: $command->lastName,
            email: $command->email,
            password: $command->password,
        );

        $user->setPatronymic(patronymic: $command->patronymic);
        $user->setPhone(phone: $command->phone);
        $user->setStatus(status: $command->status);

        $this->userRepository->save(user: $user);

        if ($user->getId()) {
            $command->userId = $user->getId();
        }

        return $next($command);
    }
}
