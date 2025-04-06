<?php declare(strict_types=1);

namespace App\Modules\Auth\Requests;

use App\Shared\Request;

final class LoginRequest extends Request
{
	/**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => [
                'bail', 'required', 'email:rfc,strict,spoof', 'max:254', 'exists:users,email'
            ],
            'password' => ['bail', 'required', 'string']
        ];
    }
}
