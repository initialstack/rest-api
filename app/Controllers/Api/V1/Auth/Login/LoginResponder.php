<?php declare(strict_types=1);

namespace App\Controllers\Api\V1\Auth\Login;

use App\Responses\TokenResponse;
use Illuminate\Http\Response;

final readonly class LoginResponder
{
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
