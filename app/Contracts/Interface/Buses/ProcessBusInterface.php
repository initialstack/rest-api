<?php declare(strict_types=1);

namespace App\Contracts\Interface\Buses;

use App\Shared\Process;

interface ProcessBusInterface
{
    /**
     * Dispatches a process and returns the result.
     *
     * @param \App\Shared\Process $process
     * @return mixed
     */
    public function run(Process $process): mixed;

    /**
     * Registers a mapping of processes to their handlers.
     *
     * @param array $map
     */
    public function register(array $map): void;
}
