<?php declare(strict_types=1);

namespace App\Buses;

use Illuminate\Bus\Dispatcher;
use App\Contracts\Interface\Buses\QueryBusInterface;
use Illuminate\Support\Facades\Log;
use App\Shared\Query;

final class QueryBus implements QueryBusInterface
{
    /**
     * The underlying dispatcher for handling query execution.
     *
     * @var \Illuminate\Bus\Dispatcher
     */
    private Dispatcher $queryBus;

    /**
     * Constructs a new QueryBus instance.
     *
     * @param \Illuminate\Bus\Dispatcher $queryBus
     */
    public function __construct(Dispatcher $queryBus)
    {
        $this->queryBus = $queryBus;
    }

    /**
     * Executes a query and returns the result.
     *
     * @param \App\Shared\Query $query
     * @return mixed
     */
    public function ask(Query $query): mixed
    {
        try {
            return $this->queryBus->dispatch(command: $query);
        }

        catch (\Exception $e) {
            Log::error(
                message: 'Error executing query.',
                context: [
                    'query' => get_class(object: $query),
                    'exception' => $e->getMessage()
                ]
            );

            throw new \RuntimeException(
                message: "Failed to execute query: {$e->getMessage()}",
                code: (int) $e->getCode(),
                previous: $e
            );
        }
    }

    /**
     * Registers a mapping of queries to their handlers.
     *
     * @param array $map
     */
    public function register(array $map): void
    {
        $this->queryBus->map(map: $map);
    }
}
