<?php declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Modules\Account\Commands\UpdateUserCommand;
use App\Modules\Account\Handlers\Write\UpdateUserHandler;
use App\Modules\Account\Commands\DeleteUserCommand;
use App\Modules\Account\Handlers\Write\DeleteUserHandler;
use App\Modules\Auth\Commands\LoginCommand;
use App\Modules\Auth\Handlers\Write\LoginHandler;
use App\Modules\Auth\Commands\RegisterCommand;
use App\Modules\Auth\Handlers\Write\RegisterHandler;
use App\Contracts\Interface\Buses\CommandBusInterface;

final class CommandServiceProvider extends ServiceProvider
{
    /**
     * Mapping of account-related commands to their handlers.
     *
     * @var array
     */
    private array $account = [
        UpdateUserCommand::class => UpdateUserHandler::class,
        DeleteUserCommand::class => DeleteUserHandler::class,
    ];

    /**
     * Mapping of authentication-related commands to their handlers.
     *
     * @var array
     */
    private array $auth = [
        LoginCommand::class => LoginHandler::class,
        RegisterCommand::class => RegisterHandler::class,
    ];

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->make(abstract: CommandBusInterface::class)
            ->register(map: $this->account);

        $this->app->make(abstract: CommandBusInterface::class)
            ->register(map: $this->auth);
    }
}
