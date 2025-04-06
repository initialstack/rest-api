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
    private readonly CommandBusInterface $commandBus;

    public function __construct(CommandBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }
    
    #[Route(methods: ['POST'], uri: '/login')]
    public function __invoke(LoginRequest $request): TokenResponse
    {
        $command = LoginCommand::fromRequest(request: $request);
        
        return new LoginResponder()->respond(
            token: $this->commandBus->send(command: $command)
        );
    }
}
