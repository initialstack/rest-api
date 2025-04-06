<?php declare(strict_types=1);

namespace App\Modules\Account\Requests;

use Illuminate\Validation\Rules\Password;
use App\Shared\Request;

final class UpdateAccountRequest extends Request
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
            'id' => ['bail', 'required', 'uuid', 'exists:users,id'],
            'avatar' => ['bail', 'nullable', 'image', 'mimes:jpeg,jpg,png,gif', 'max:3072'],
            'first_name' => ['bail', 'required', 'string', 'min:2', 'max:18'],
            'last_name' => ['bail', 'required', 'string', 'min:2', 'max:27'],
            'patronymic' => ['bail', 'nullable', 'string', 'min:2', 'max:16'],
            'phone' => ['bail', 'nullable', 'string', 'min:11', 'max:20', 'unique:users,phone,' . $this->id],
            'email' => [
                'bail', 'required', 'email:rfc,strict,spoof,dns', 'max:254', 'unique:users,email,' . $this->id
            ],
            'password' => ['bail', 'required', 'string', $pwdRules, 'confirmed'],
            'status' => ['bail', 'nullable', 'boolean'],
            'role_id' => ['bail', 'nullable', 'uuid', 'exists:roles,id']
        ];
    }

    /**
     * Prepare the request data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge(input: [
            'id' => $this->route('id')
        ]);

        if ($this->has(key: 'status')) {
            $this->merge(input: [
                'status' => filter_var(
	                value: $this->boolean(key: 'status'),
	                filter: FILTER_VALIDATE_BOOLEAN,
	                options: FILTER_NULL_ON_FAILURE
                )
            ]);
        }
    }
}

