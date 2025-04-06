<?php declare(strict_types=1);

namespace App\Controllers\Api\V1\Auth\Register;

use App\Shared\Controller as Action;
use App\Contracts\Interface\Buses\CommandBusInterface;
use App\Modules\Auth\Requests\RegisterRequest;
use App\Modules\Auth\Commands\RegisterCommand;
use Spatie\RouteAttributes\Attributes\{Prefix, Route};
use App\Responses\MessageResponse;

#[Prefix(prefix: 'v1')]
final class RegisterAction extends Action
{
    /**
     * Command bus instance for executing commands.
     */
    private readonly CommandBusInterface $commandBus;

    /**
     * Constructs a new RegisterAction instance.
     *
     * Initializes the command bus for handling commands.
     *
     * @param \App\Contracts\Interface\Buses\CommandBusInterface $commandBus
     */
    public function __construct(CommandBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * Handles POST requests to the registration endpoint.
     *
     * Processes the registration request and returns a response.
     *
     * @param \App\Modules\Auth\Requests\RegisterRequest $request
     * @return \App\Interaction\Responses\MessageResponse
     */
    #[Route(methods: ['POST'], uri: '/register')]
    public function __invoke(
        RegisterRequest $request): MessageResponse
    {
        $command = RegisterCommand::fromRequest(request: $request);
        
        return new RegisterResponder()->respond(
            result: $this->commandBus->send(command: $command)
        );
    }
}
