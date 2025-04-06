<?php declare(strict_types=1);

namespace App\Buses;

use Illuminate\Bus\Dispatcher;
use App\Contracts\Interface\Buses\EventBusInterface;
use Illuminate\Support\Facades\Log;
use App\Shared\Event;

final class EventBus implements EventBusInterface
{
    /**
     * The underlying dispatcher for handling event execution.
     *
     * @var \Illuminate\Bus\Dispatcher
     */
    private Dispatcher $eventBus;

    /**
     * Constructs a new EventBus instance.
     *
     * @param \Illuminate\Bus\Dispatcher $eventBus
     */
    public function __construct(Dispatcher $eventBus)
    {
        $this->eventBus = $eventBus;
    }

    /**
     * Dispatches an event and returns the result.
     *
     * @param \App\Shared\Event $event
     * @return mixed
     */
    public function dispatch(Event $event): mixed
    {
        try {
            return event($this->eventBus->dispatch(event: $event));
        }

        catch (\Exception $e) {
            Log::error(
                message: 'Error dispatching event.',
                context: [
                    'event' => get_class(object: $event),
                    'exception' => $e->getMessage()
                ]
            );

            throw new \RuntimeException(
                message: "Failed to dispatch event: {$e->getMessage()}",
                code: (int) $e->getCode(),
                previous: $e
            );
        }
    }

    /**
     * Registers a mapping of events to their listeners.
     *
     * @param array $map
     */
    public function register(array $map): void
    {
        $this->eventBus->map(map: $map);
    }
}
