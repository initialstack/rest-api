<?php declare(strict_types=1);

namespace App\Controllers\Api\V1\User\Delete;

use App\Shared\Controller as Action;
use App\Contracts\Interface\Buses\ProcessBusInterface;
use App\Modules\Account\Requests\DeleteAccountRequest;
use App\Modules\Account\Processes\DeleteAccountProcess;
use Spatie\RouteAttributes\Attributes\Prefix;
use Spatie\RouteAttributes\Attributes\Middleware;
use Spatie\RouteAttributes\Attributes\Route;
use App\Responses\MessageResponse;

#[Prefix(prefix: 'v1')]
#[Middleware(middleware: 'auth:api')]
final class DeleteUserAction extends Action
{
	private readonly ProcessBusInterface $processBus;

	public function __construct(ProcessBusInterface $processBus)
	{
		$this->processBus = $processBus;
	}

	#[Route(methods: ['DELETE'], uri: '/users/{id}/delete')]
	public function __invoke(
		string $id, DeleteAccountRequest $request): MessageResponse
	{
		$process = new DeleteAccountProcess(request: $request);
		
		return new DeleteUserResponder()->respond(
			result: $this->processBus->run(process: $process)
		);
	}
}
