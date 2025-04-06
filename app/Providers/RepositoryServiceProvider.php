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
   $roles = [
        RoleMemoryRepositoryInterface::class => RoleMemoryRepository::class,
        RoleStorageRepositoryInterface::class => RoleCachedRepository::class,
        RoleRepositoryInterface::class => RoleRepository::class,
    ];

    $permissions = [
        PermissionMemoryRepositoryInterface::class => PermissionMemoryRepository::class,
        PermissionStorageRepositoryInterface::class => PermissionCachedRepository::class,
        PermissionRepositoryInterface::class => PermissionRepository::class,
    ];

    $media = [
        MediaMemoryRepositoryInterface::class => MediaMemoryRepository::class,
        MediaStorageRepositoryInterface::class => MediaCachedRepository::class,
        MediaRepositoryInterface::class => MediaRepository::class,
    ];

    $users = [
        UserMemoryRepositoryInterface::class => UserMemoryRepository::class,
        UserStorageRepositoryInterface::class => UserCachedRepository::class,
        UserRepositoryInterface::class => UserRepository::class,
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $bindings = [
            ...$this->roles,
            ...$this->permissions,
            ...$this->media,
            ...$this->users
        ];

        foreach ($bindings as $abstract => $concrete) {
            $this->app->bind(abstract: $abstract, concrete: $concrete);
        }
    }
}
