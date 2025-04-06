<?php declare(strict_types=1);

namespace App\Controllers\Api\V1\User\Show;

use App\Responses\ResourceResponse;
use App\Modules\Account\Resources\ShowUserResource;
use Illuminate\Http\Response;

final readonly class ShowUserResponder
{
	public function respond(mixed $data): ResourceResponse
	{
		if (!blank(value: $data)) {
			return new ResourceResponse(
	            data: new ShowUserResource(resource: $data),
	            status: Response::HTTP_OK
	        );
		}

		return new ResourceResponse(
			data: ['message' => __('User Not Found.')],
			status: Response::HTTP_NOT_FOUND
		);
	}
}
