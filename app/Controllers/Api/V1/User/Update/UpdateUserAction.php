<?php declare(strict_types=1);

namespace App\Controllers\Api\V1\User\Update;

use App\Shared\Controller as Action;
use App\Contracts\Interface\Buses\ProcessBusInterface;
use App\Modules\Account\Requests\UpdateAccountRequest;
use App\Modules\Account\Processes\UpdateAccountProcess;
use Spatie\RouteAttributes\Attributes\Prefix;
use Spatie\RouteAttributes\Attributes\Middleware;
use Spatie\RouteAttributes\Attributes\Route;
use App\Responses\MessageResponse;

#[Prefix(prefix: 'v1')]
#[Middleware(middleware: 'auth:api')]
final class UpdateUserAction extends Action
{
	private readonly ProcessBusInterface $processBus;

	public function __construct(ProcessBusInterface $processBus)
	{
		$this->processBus = $processBus;
	}

	#[Route(methods: ['PUT'], uri: '/users/{id}/update')]
	public function __invoke(
		string $id, UpdateAccountRequest $request): MessageResponse
	{
		$process = new UpdateAccountProcess(request: $request);
		
		return new UpdateUserResponder()->respond(
			result: $this->processBus->run(process: $process)
		);
	}
}
