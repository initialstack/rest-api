<?php declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\Interface\Buses\CommandBusInterface;
use App\Buses\CommandBus;
use App\Contracts\Interface\Buses\EventBusInterface;
use App\Buses\EventBus;
use App\Contracts\Interface\Buses\QueryBusInterface;
use App\Buses\ProcessBus;
use App\Contracts\Interface\Buses\ProcessBusInterface;
use App\Buses\QueryBus;

final class BusServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(
            abstract: CommandBusInterface::class,
            concrete: CommandBus::class
        );

        $this->app->singleton(
            abstract: EventBusInterface::class,
            concrete: EventBus::class
        );

        $this->app->singleton(
            abstract: ProcessBusInterface::class,
            concrete: ProcessBus::class
        );

        $this->app->singleton(
            abstract: QueryBusInterface::class,
            concrete: QueryBus::class
        );
    }
}
