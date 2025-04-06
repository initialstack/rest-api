<?php declare(strict_types=1);

namespace App\Shared;

use Illuminate\Pipeline\Pipeline;
use App\Shared\{Request, Command};

abstract class Process
{
    /**
     * Array of tasks to be executed in the pipeline.
     *
     * @var callable[]
     */
    protected array $tasks = [];

    /**
     * Initializes a new process instance.
     *
     * @param \App\Shared\Request  $request
     * @param \App\Shared\Command $command
     */
    protected function __construct(
        protected Request $request,
        protected Command $command
    ) {}

    /**
     * Runs the pipeline with the given request.
     *
     * @return mixed
     *
     * @throws \RuntimeException
     * @throws \Throwable
     */
    public function run(): mixed
    {
        $this->validateTasks();

        try {
            $command = $this->command::fromRequest(
                request:$this->request
            );

            foreach ($this->tasks as $task) {
                $command = $task->handle(
                    command: $command,
                    next: fn ($command) => $command
                );
            }

            return $command;
        }

        catch (\Throwable $e) {
            throw new \RuntimeException(
                message: "Failed to execute pipeline: {$e->getMessage()}",
                code: (int) $e->getCode(),
                previous: $e
            );
        }
    }

    /**
     * Validates pipeline tasks as non-empty and callable.
     *
     * @throws \RuntimeException
     */
    private function validateTasks(): void
    {
        $filled = filled(value: $this->tasks);

        $tasks = array_map(
            callback: fn ($task) => is_string(value: $task)
                ? app(abstract: $task)
                : $task,
            array: $this->tasks
        );

        foreach ($tasks as $task) {
            if (!method_exists(object_or_class: $task, method: 'handle'))
            {
                $message = 'Task does not have a handle method: ';

                throw new \RuntimeException(
                    message: $message . (
                        is_object(value: $task)
                            ? get_class(object: $task)
                            : (string) $task
                    )
                );
            }
        }

        if (!$filled) {
            throw new \RuntimeException(
                message: 'No valid tasks defined for the process.'
            );
        }

        $this->tasks = $tasks;
    }

    /**
     * Adds new tasks to the pipeline.
     *
     * @param callable[] $map
     */
    public function map(array $map): void
    {
        $this->tasks = [...$this->tasks, ...$map];
    }
}
