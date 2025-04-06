<?php declare(strict_types=1);

namespace App\Controllers\Api\V1\User\Show;

use App\Shared\Controller as Action;
use App\Modules\Account\Queries\GetUserByIdQuery;
use App\Contracts\Interface\Buses\QueryBusInterface;
use Spatie\RouteAttributes\Attributes\Prefix;
use Spatie\RouteAttributes\Attributes\Middleware;
use Spatie\RouteAttributes\Attributes\Route;
use App\Responses\ResourceResponse;

#[Prefix(prefix: 'v1')]
#[Middleware(middleware: 'auth:api')]
final class ShowUserAction extends Action
{
	private readonly QueryBusInterface $queryBus;

	public function __construct(QueryBusInterface $queryBus)
	{
		$this->queryBus = $queryBus;
	}

	#[Route(methods: ['GET'], uri: '/users/{id}/show')]
	public function __invoke(string $id): ResourceResponse
	{
		$query = new GetUserByIdQuery(userId: $id);
		
		return new ShowUserResponder()->respond(
			data: $this->queryBus->ask(query: $query)
		);
	}
}
