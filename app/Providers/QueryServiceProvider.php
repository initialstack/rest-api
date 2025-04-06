<?php declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Modules\Account\Queries\GetAllUsersQuery;
use App\Modules\Account\Handlers\Read\GetAllUsersQueryHandler;
use App\Modules\Account\Queries\GetUserByIdQuery;
use App\Modules\Account\Handlers\Read\GetUserByIdQueryHandler;
use App\Modules\Auth\Queries\GetCurrentUserQuery;
use App\Modules\Auth\Handlers\Read\GetCurrentUserQueryHandler;
use App\Modules\Auth\Queries\SignOutUserQuery;
use App\Modules\Auth\Handlers\Read\SignOutUserQueryHandler;
use App\Contracts\Interface\Buses\QueryBusInterface;

final class QueryServiceProvider extends ServiceProvider
{
    /**
     * Mapping of queries to their handlers.
     * 
     * @var array
     */
    private array $queries = [
        GetAllUsersQuery::class => GetAllUsersQueryHandler::class,
        GetUserByIdQuery::class => GetUserByIdQueryHandler::class,
        GetCurrentUserQuery::class => GetCurrentUserQueryHandler::class,
        SignOutUserQuery::class => SignOutUserQueryHandler::class,
    ];

    /**
     * Bootstrap any application services.
     */
    public function boot(QueryBusInterface $queryBus): void
    {
        $queryBus->register(map: $this->queries);
    }
}
