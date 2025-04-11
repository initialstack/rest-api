<?php declare(strict_types=1);

namespace App\Responses;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\Context;
use Illuminate\Http\{JsonResponse, Response};

final class TokenResponse implements Responsable
{
    /**
     * Constructs a new TokenResponse instance.
     *
     * @param string $message
     * @param int $status
     * @param string|null $token
     */
    public function __construct(
        private string $message,
        private int $status,
        private ?string $token = null,
    ) {}

    /**
     * Converts the response to a JSON response.
     *
     * @param mixed $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function toResponse($request): JsonResponse
    {
        $requestId = Context::get(key: 'request_id');
        $timestamp = Context::get(key: 'timestamp');

        $response = [
            'status' => $this->status,
            'data' => [
                'message' => __(key: $this->message),
            ],
            'metadata' => [
                'request_id' => $requestId,
                'timestamp' => $timestamp,
            ],
        ];

        if ($this->token !== null) {
            $ttl = config(key: 'auth.guards.api.ttl');
            $response['data']['access_token'] = __(
                key: $this->token
            );
            $response['data']['token_type'] = 'bearer';
            $response['data']['expires_in'] = $ttl * 60;
        }

        return new JsonResponse(
            data: $response, status: $this->status
        );
    }
}
