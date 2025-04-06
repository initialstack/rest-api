<?php declare(strict_types=1);

namespace App\Controllers\Api\V1\User\Update;

use App\Responses\MessageResponse;
use Illuminate\Http\Response;

final readonly class UpdateUserResponder
{
	public function respond(bool $result): MessageResponse
	{
		if ($result) {
			return new MessageResponse(
	            message: 'User Successfully Updated!',
	            status: Response::HTTP_OK
	        );
		}

		return new MessageResponse(
			message: 'Failed To Update User.',
			status: Response::HTTP_INTERNAL_SERVER_ERROR
		);
	}
}
