<?php declare(strict_types=1);

namespace App\Controllers\Api\V1\Auth\Login;

use App\Shared\Controller as Action;
use App\Contracts\Interface\Buses\CommandBusInterface;
use App\Modules\Auth\Requests\LoginRequest;
use App\Modules\Auth\Commands\LoginCommand;
use Spatie\RouteAttributes\Attributes\{Prefix, Route};
use App\Responses\TokenResponse;

#[Prefix(prefix: 'v1')]
final class LoginAction extends Action
{
    /**
     * Command bus instance for executing commands.
     */
    private readonly CommandBusInterface $commandBus;

    /**
     * Constructs a new LoginAction instance.
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
     * Handles POST requests to the login endpoint.
     *
     * Authenticates the user and returns a token response.
     *
     * @param \App\Modules\Auth\Requests\LoginRequest $request
     * @return \App\Interaction\Responses\TokenResponse
     */
    #[Route(methods: ['POST'], uri: '/login')]
    public function __invoke(LoginRequest $request): TokenResponse
    {
        $command = LoginCommand::fromRequest(request: $request);
        
        return new LoginResponder()->respond(
            token: $this->commandBus->send(command: $command)
        );
    }
}
