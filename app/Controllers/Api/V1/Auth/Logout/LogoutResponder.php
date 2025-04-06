<?php declare(strict_types=1);

namespace App\Controllers\Api\V1\Auth\Logout;

use App\Responses\MessageResponse;
use App\Modules\Auth\Resources\CheckMeResource;
use Illuminate\Http\Response;

final readonly class LogoutResponder
{
    /**
     * Generates a response based on the logout result.
     *
     * If the logout is successful, returns a success message with a 200 status.
     * Otherwise, returns a failure message with a 400 status.
     *
     * @param bool $result
     * @return \App\Interaction\Responses\MessageResponse
     */
	public function respond(bool $result): MessageResponse
    {
        if ($result) {
            return new MessageResponse(
                message: __('You have been logged out successfully!'),
                status: Response::HTTP_OK
            );
        }

        return new MessageResponse(
            message: __('Logout failed. Please try again.'),
            status: Response::HTTP_BAD_REQUEST
        );
    }
}
