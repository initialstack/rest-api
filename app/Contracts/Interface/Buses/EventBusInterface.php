<?php declare(strict_types=1);

namespace App\Contracts\Interface\Buses;

use App\Shared\Event;
use Illuminate\Bus\Dispatcher;

interface EventBusInterface
{
    /**
     * Dispatches an event and returns the result.
     *
     * @param \App\Shared\Event $event
     * @return mixed
     */
    public function dispatch(Event $event): mixed;

    /**
     * Registers a mapping of events to their listeners.
     *
     * @param array $map
     */
    public function register(array $map): void;
}
