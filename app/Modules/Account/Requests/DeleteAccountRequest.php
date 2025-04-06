<?php declare(strict_types=1);

namespace App\Modules\Account\Requests;

use App\Shared\Request;

final class DeleteAccountRequest extends Request
{
	/**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id' => ['bail', 'required', 'uuid', 'exists:users,id']
        ];
    }

    /**
     * Prepare the request data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge(input: ['id' => $this->route('id')]);
    }
}
