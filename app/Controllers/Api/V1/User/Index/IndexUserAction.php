<?php declare(strict_types=1);

namespace App\Controllers\Api\V1\User\Index;

use App\Shared\Controller as Action;
use App\Modules\Account\Queries\GetAllUsersQuery;
use App\Contracts\Interface\Buses\QueryBusInterface;
use Spatie\RouteAttributes\Attributes\Prefix;
use Spatie\RouteAttributes\Attributes\Middleware;
use Spatie\RouteAttributes\Attributes\Route;
use App\Responses\ResourceResponse;

#[Prefix(prefix: 'v1')]
#[Middleware(middleware: 'auth:api')]
final class IndexUserAction extends Action
{
	private readonly QueryBusInterface $queryBus;

	public function __construct(QueryBusInterface $queryBus)
	{
		$this->queryBus = $queryBus;
	}

	#[Route(methods: ['GET'], uri: '/users')]
	public function __invoke(): ResourceResponse
	{
		$query = new GetAllUsersQuery();

		return new IndexUserResponder()->respond(
			data: $this->queryBus->ask(query: $query)
		);
	}
}
