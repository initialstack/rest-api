<?php declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Spatie\RouteAttributes\RouteRegistrar;

final class RouteServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        $directories = config(
            key: 'route-attributes.directories'
        );

        $isEnabled = config(key: 'route-attributes.enabled');

        if ($isEnabled) {
            foreach ($directories as $path => $options) {
                $controllers = scan(path: $path,
                    namespace: $options['namespace']
                );

                foreach ($controllers as $controller) {
                    $this->app->make(
                        abstract: RouteRegistrar::class
                    )->middleware(
                        middleware: $options['middleware'] ?? []
                    )->prefix(
                        prefix: $options['prefix'] ?? ''
                    )->patterns(
                        patterns: $options['patterns'] ?? []
                    )->registerClass(
                        class: $controller
                    );
                }
            }
        }
    }
}
