<?php declare(strict_types=1);

namespace App\Controllers\Api\V1\User\Index;

use App\Responses\ResourceResponse;
use App\Modules\Account\Resources\IndexUserResource;
use Illuminate\Http\Response;

final readonly class IndexUserResponder
{
	public function respond(mixed $data): ResourceResponse
	{
		if (!blank(value: $data)) {
			return new ResourceResponse(
	            data: IndexUserResource::collection(resource: $data),
	            status: Response::HTTP_OK
	        );
		}

		return new ResourceResponse(
			data: ['message' => __('No Users Found.')],
			status: Response::HTTP_NOT_FOUND
		);
	}
}
