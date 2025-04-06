<?php declare(strict_types=1);

namespace App\Controllers\Api\V1\Auth\Login;

use App\Responses\TokenResponse;
use Illuminate\Http\Response;

final readonly class LoginResponder
{
	/**
     * Generates a response based on the provided token.
     *
     * If a token is present, returns a successful TokenResponse with the token.
     * Otherwise, returns a failure message with a 401 status.
     *
     * @param string|null $token
     * @return \App\Responses\TokenResponse
     */
	public function respond(?string $token): TokenResponse
	{
		if (is_string(value: $token)) {
			return new TokenResponse(
                message: 'Token Successfully Generated!',
                token: $token,
                status: Response::HTTP_OK,
            );
		}

		return new TokenResponse(
			message: 'Failed To Generate Token.',
			status: Response::HTTP_UNAUTHORIZED
		);
	}
}
