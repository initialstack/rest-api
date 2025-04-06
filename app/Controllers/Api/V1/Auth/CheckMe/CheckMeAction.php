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
	/**
     * Query bus instance for executing queries.
     */
    private readonly QueryBusInterface $queryBus;

    /**
     * Constructs a new CheckMeAction instance.
     *
     * Initializes the query bus for handling queries.
     *
     * @param \App\Contracts\Interface\Buses\QueryBusInterface $queryBus
     */
    public function __construct(QueryBusInterface $queryBus)
    {
        $this->queryBus = $queryBus;
    }

    /**
     * Handles GET requests to the "Check Me" endpoint.
     *
     * Retrieves the current authenticated user and returns a response.
     *
     * @return \App\Interaction\Responses\ResourceResponse
     */
	#[Route(methods: ['GET'], uri: '/check-me')]
	public function __invoke(): ResourceResponse
	{
		$query = new GetCurrentUserQuery();

		return new CheckMeResponder()->respond(
			data: $this->queryBus->ask(query: $query)
		);
	}
}
