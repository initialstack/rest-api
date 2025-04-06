<?php declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\Interface\Buses\CommandBusInterface;
use App\Modules\Auth\Commands\LoginCommand;
use App\Modules\Auth\Handlers\Write\LoginHandler;
use App\Modules\Auth\Commands\RegisterCommand;
use App\Modules\Auth\Handlers\Write\RegisterHandler;

final class CommandServiceProvider extends ServiceProvider
{
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
            ->register(map: $this->auth);
    }
}
