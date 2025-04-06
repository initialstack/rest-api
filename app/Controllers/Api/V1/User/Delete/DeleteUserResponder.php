<?php declare(strict_types=1);

namespace App\Controllers\Api\V1\User\Delete;

use App\Responses\MessageResponse;
use Illuminate\Http\Response;

final readonly class DeleteUserResponder
{
	public function respond(bool $result): MessageResponse
	{
		if ($result) {
			return new MessageResponse(
	            message: 'User Successfully Deleted!',
	            status: Response::HTTP_OK
	        );
		}

		return new MessageResponse(
			message: 'Failed To Delete User.',
			status: Response::HTTP_INTERNAL_SERVER_ERROR
		);
	}
}
