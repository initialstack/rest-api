<?php declare(strict_types=1);

namespace App\Controllers\Api\V1\Auth\Register;

use App\Responses\MessageResponse;
use Illuminate\Http\Response;

final readonly class RegisterResponder
{
	public function respond(bool $result): MessageResponse
    {
        if ($result) {
            return new MessageResponse(
                message: __('Registration successful!'),
                status: Response::HTTP_OK
            );
        }

        return new MessageResponse(
            message: __('Registration failed. Try again.'),
            status: Response::HTTP_BAD_REQUEST
        );
    }
}
