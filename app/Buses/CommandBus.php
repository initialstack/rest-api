<?php declare(strict_types=1);

namespace App\Buses;

use Illuminate\Bus\Dispatcher;
use App\Contracts\Interface\Buses\CommandBusInterface;
use Illuminate\Support\Facades\Log;
use App\Shared\Command;

final class CommandBus implements CommandBusInterface
{
    /**
     * The underlying dispatcher for handling command execution.
     *
     * @var \Illuminate\Bus\Dispatcher
     */
    private Dispatcher $commandBus;

    /**
     * Constructs a new CommandBus instance.
     *
     * @param \Illuminate\Bus\Dispatcher $commandBus
     */
    public function __construct(Dispatcher $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * Dispatches a command and returns the result.
     *
     * @param Command $command
     * @return mixed
     */
    public function send(Command $command): mixed
    {
        try {
            return $this->commandBus->dispatch(command: $command);
        }

        catch (\Exception $e) {
            Log::error(
                message: 'Error dispatching command.',
                context: [
                    'command' => get_class(object: $command),
                    'exception' => $e->getMessage()
                ]
            );

            throw new \RuntimeException(
                message: "Failed to dispatch command: {$e->getMessage()}",
                code: (int) $e->getCode(),
                previous: $e
            );
        }
    }

    /**
     * Registers a mapping of commands to their handlers.
     *
     * @param array $map
     */
    public function register(array $map): void
    {
        $this->commandBus->map(map: $map);
    }
}
