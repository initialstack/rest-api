<?php declare(strict_types=1);

namespace App\Controllers\Api\V1\Auth\Logout;

use App\Shared\Controller as Action;
use App\Modules\Auth\Queries\SignOutUserQuery;
use App\Contracts\Interface\Buses\QueryBusInterface;
use Spatie\RouteAttributes\Attributes\Prefix;
use Spatie\RouteAttributes\Attributes\Middleware;
use Spatie\RouteAttributes\Attributes\Route;
use App\Responses\MessageResponse;
use Illuminate\Http\Request;

#[Prefix(prefix: 'v1')]
#[Middleware(middleware: 'auth:api')]
final class LogoutAction extends Action
{
    private readonly QueryBusInterface $queryBus;

    public function __construct(QueryBusInterface $queryBus)
    {
        $this->queryBus = $queryBus;
    }
    
    #[Route(methods: ['POST'], uri: '/logout')]
    public function __invoke(Request $request): MessageResponse
    {
        $query = new SignOutUserQuery();
        
        return new LogoutResponder()->respond(
            result: $this->queryBus->ask(query: $query)
        );
    }
}
