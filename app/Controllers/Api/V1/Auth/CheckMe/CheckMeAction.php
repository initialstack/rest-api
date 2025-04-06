<?php declare(strict_types=1);

namespace App\Controllers\Api\V1\Auth\CheckMe;

use App\Shared\Controller as Action;
use App\Modules\Auth\Queries\GetCurrentUserQuery;
use App\Contracts\Interface\Buses\QueryBusInterface;
use Spatie\RouteAttributes\Attributes\Prefix;
use Spatie\RouteAttributes\Attributes\Middleware;
use Spatie\RouteAttributes\Attributes\Route;
use App\Responses\ResourceResponse;

#[Prefix(prefix: 'v1')]
#[Middleware(middleware: 'auth:api')]
final class CheckMeAction extends Action
{
    private readonly QueryBusInterface $queryBus;

    public function __construct(QueryBusInterface $queryBus)
    {
        $this->queryBus = $queryBus;
    }
    
	#[Route(methods: ['GET'], uri: '/check-me')]
	public function __invoke(): ResourceResponse
	{
		$query = new GetCurrentUserQuery();

		return new CheckMeResponder()->respond(
			data: $this->queryBus->ask(query: $query)
		);
	}
}
