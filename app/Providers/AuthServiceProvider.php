<?php declare(strict_types=1);

namespace App\Providers;

use App\Services\Application;
use Illuminate\Support\ServiceProvider;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Support\Facades\Auth;
use App\Services\Authenticate;

final class AuthServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Auth::provider(name: 'doctrine',
            callback: function (Application $app, array $config): Authenticate {
                return new Authenticate(entityManager: $app->make(
                    abstract: EntityManagerInterface::class
                ));
            }
        );
    }
}
