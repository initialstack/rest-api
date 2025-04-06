<?php declare(strict_types=1);

namespace App\Providers;

use App\Contracts\Interface\Buses\EventBusInterface;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

final class EventServiceProvider extends ServiceProvider
{
    /**
     * Mapping of events and listeners.
     *
     * @var array
     */
    protected $listen = [];
    
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->booted(
            callback: function (): void {
                $this->app->make(
                    abstract: EventBusInterface::class
                )->register(
                    map: $this->listen
                );
            }
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        parent::boot();
    }
}
