<?php declare(strict_types=1);

namespace App\Controllers\Api\V1\Auth\CheckMe;

use App\Responses\ResourceResponse;
use App\Modules\Auth\Resources\CheckMeResource;
use Illuminate\Http\Response;

final readonly class CheckMeResponder
{
	/**
     * Generates a response based on the provided data.
     *
     * If data is present, returns a ResourceResponse with the CheckMeResource.
     * Otherwise, returns a "User Not Found" message with a 404 status.
     *
     * @param mixed $data
     * @return \App\Interaction\Responses\ResourceResponse
     */
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
