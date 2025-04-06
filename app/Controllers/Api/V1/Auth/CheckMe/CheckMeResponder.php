<?php declare(strict_types=1);

namespace App\Controllers\Api\V1\Auth\CheckMe;

use App\Responses\ResourceResponse;
use App\Modules\Auth\Resources\CheckMeResource;
use Illuminate\Http\Response;

final readonly class CheckMeResponder
{
	public function respond(mixed $data): ResourceResponse
	{
		if (!blank(value: $data)) {
			return new ResourceResponse(
	            data: new CheckMeResource(resource: $data),
	            status: Response::HTTP_OK
	        );
		}

		return new ResourceResponse(
			data: ['message' => __('User Not Found.')],
			status: Response::HTTP_NOT_FOUND
		);
	}
}
