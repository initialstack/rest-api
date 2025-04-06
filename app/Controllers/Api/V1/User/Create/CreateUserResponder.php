<?php declare(strict_types=1);

namespace App\Controllers\Api\V1\User\Create;

use App\Responses\MessageResponse;
use Illuminate\Http\Response;

final readonly class CreateUserResponder
{
	public function respond(bool $result): MessageResponse
	{
		if ($result) {
			return new MessageResponse(
	            message: 'User Successfully Created!',
	            status: Response::HTTP_CREATED
	        );
		}

		return new MessageResponse(
			message: 'Failed To Create User.',
			status: Response::HTTP_INTERNAL_SERVER_ERROR
		);
	}
}
