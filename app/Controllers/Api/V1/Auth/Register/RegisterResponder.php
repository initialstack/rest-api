<?php declare(strict_types=1);

namespace App\Controllers\Api\V1\Auth\Register;

use App\Responses\MessageResponse;
use Illuminate\Http\Response;

final readonly class RegisterResponder
{
    /**
     * Generates a response based on the registration result.
     *
     * If registration is successful, returns a success message with a 200 status.
     * Otherwise, returns a failure message with a 400 status.
     *
     * @param bool $result
     * @return \App\Interaction\Responses\MessageResponse
     */
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
