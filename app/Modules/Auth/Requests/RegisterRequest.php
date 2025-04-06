<?php declare(strict_types=1);

namespace App\Modules\Auth\Requests;

use Illuminate\Validation\Rules\Password;
use App\Shared\Request;

final class RegisterRequest extends Request
{
	/**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $pwdRules = Password::min(size: 8)->letters()->numbers()->symbols();

        return [
            'first_name' => ['bail', 'required', 'string', 'min:2', 'max:18'],
            'last_name' => ['bail', 'required', 'string', 'min:2', 'max:27'],
            'email' => [
                'bail', 'required', 'email:rfc,strict,spoof,dns', 'max:254', 'unique:users,email'
            ],
            'password' => ['bail', 'required', 'string', $pwdRules, 'confirmed'],
        ];
    }
}

