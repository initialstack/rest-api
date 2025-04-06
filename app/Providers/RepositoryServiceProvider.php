<?php declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\Interface\Repositories\Memory\MediaMemoryRepositoryInterface;
use App\Repositories\Memory\MediaMemoryRepository;
use App\Contracts\Interface\Repositories\Storage\MediaStorageRepositoryInterface;
use App\Repositories\Storage\Cached\MediaCachedRepository;
use App\Contracts\Interface\Repositories\Memory\PermissionMemoryRepositoryInterface;
use App\Repositories\Memory\PermissionMemoryRepository;
use App\Contracts\Interface\Repositories\Storage\PermissionStorageRepositoryInterface;
use App\Repositories\Storage\Cached\PermissionCachedRepository;
use App\Contracts\Interface\Repositories\Memory\RoleMemoryRepositoryInterface;
use App\Repositories\Memory\RoleMemoryRepository;
use App\Contracts\Interface\Repositories\Storage\RoleStorageRepositoryInterface;
use App\Repositories\Storage\Cached\RoleCachedRepository;
use App\Contracts\Interface\Repositories\Memory\UserMemoryRepositoryInterface;
use App\Repositories\Memory\UserMemoryRepository;
use App\Contracts\Interface\Repositories\Storage\UserStorageRepositoryInterface;
use App\Repositories\Storage\Cached\UserCachedRepository;
use App\Contracts\Interface\Repositories\RoleRepositoryInterface;
use App\Repositories\RoleRepository;
use App\Contracts\Interface\Repositories\PermissionRepositoryInterface;
use App\Repositories\PermissionRepository;
use App\Contracts\Interface\Repositories\MediaRepositoryInterface;
use App\Repositories\MediaRepository;
use App\Contracts\Interface\Repositories\UserRepositoryInterface;
use App\Repositories\UserRepository;

final class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            abstract: MediaMemoryRepositoryInterface::class,
            concrete: MediaMemoryRepository::class
        );

        $this->app->bind(
            abstract: MediaStorageRepositoryInterface::class,
            concrete: MediaCachedRepository::class
        );

        $this->app->bind(
            abstract: PermissionMemoryRepositoryInterface::class,
            concrete: PermissionMemoryRepository::class
        );

        $this->app->bind(
            abstract: PermissionStorageRepositoryInterface::class,
            concrete: PermissionCachedRepository::class
        );

        $this->app->bind(
            abstract: RoleMemoryRepositoryInterface::class,
            concrete: RoleMemoryRepository::class
        );

        $this->app->bind(
            abstract: RoleStorageRepositoryInterface::class,
            concrete: RoleCachedRepository::class
        );

        $this->app->bind(
            abstract: UserMemoryRepositoryInterface::class,
            concrete: UserMemoryRepository::class
        );

        $this->app->bind(
            abstract: UserStorageRepositoryInterface::class,
            concrete: UserCachedRepository::class
        );

        $this->app->bind(
            abstract: RoleRepositoryInterface::class,
            concrete: RoleRepository::class
        );
        
        $this->app->bind(
            abstract: PermissionRepositoryInterface::class,
            concrete: PermissionRepository::class
        );
        
        $this->app->bind(
            abstract: MediaRepositoryInterface::class,
            concrete: MediaRepository::class
        );
        
        $this->app->bind(
            abstract: UserRepositoryInterface::class,
            concrete: UserRepository::class
        );
    }
}
