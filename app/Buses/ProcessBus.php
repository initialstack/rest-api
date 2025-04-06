<?php declare(strict_types=1);

namespace App\Buses;

use Illuminate\Bus\Dispatcher;
use App\Contracts\Interface\Buses\ProcessBusInterface;
use Illuminate\Support\Facades\Log;
use App\Shared\Process;

final class ProcessBus implements ProcessBusInterface
{
    /**
     * The underlying dispatcher for handling process execution.
     *
     * @var \Illuminate\Bus\Dispatcher
     */
    private Dispatcher $processBus;

    /**
     * Constructs a new ProcessBus instance.
     *
     * @param \Illuminate\Bus\Dispatcher $processBus
     */
    public function __construct(Dispatcher $processBus)
    {
        $this->processBus = $processBus;
    }

    /**
     * Dispatches a process and returns the result.
     *
     * @param \App\Shared\Process $process
     * @return mixed
     */
    public function run(Process $process): mixed
    {
        try {
            return $this->processBus->dispatch(command: $process);
        }

        catch (\Throwable $e) {
            Log::error(
                message: 'Error dispatching process.',
                context: [
                    'process' => get_class(object: $process),
                    'exception' => $e->getMessage()
                ]
            );

            throw new \RuntimeException(
                message: "Failed to dispatch process: {$e->getMessage()}",
                code: (int) $e->getCode(),
                previous: $e
            );
        }
    }

    /**
     * Registers a mapping of processes to their handlers.
     *
     * @param array $map
     */
    public function register(array $map): void
    {
        $this->processBus->map(map: $map);
    }
}
