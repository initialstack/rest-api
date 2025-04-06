<?php declare(strict_types=1);

namespace App\Controllers\Api\V1\User\Create;

use App\Shared\Controller as Action;
use App\Contracts\Interface\Buses\ProcessBusInterface;
use App\Modules\Account\Requests\CreateAccountRequest;
use App\Modules\Account\Processes\CreateAccountProcess;
use Spatie\RouteAttributes\Attributes\Prefix;
use Spatie\RouteAttributes\Attributes\Middleware;
use Spatie\RouteAttributes\Attributes\Route;
use App\Responses\MessageResponse;

#[Prefix(prefix: 'v1')]
final class CreateUserAction extends Action
{
	private readonly ProcessBusInterface $processBus;

	public function __construct(ProcessBusInterface $processBus)
	{
		$this->processBus = $processBus;
	}

	#[Route(methods: ['POST'], uri: '/users/create')]
	public function __invoke(
		CreateAccountRequest $request): MessageResponse
	{
		$process = new CreateAccountProcess(request: $request);

		return new CreateUserResponder()->respond(
			result: $this->processBus->run(process: $process)
		);
	}
}
