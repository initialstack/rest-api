<?php declare(strict_types=1);

namespace App\DtoCasts;

use WendellAdriel\ValidatedDTO\Casting\Castable;
use Illuminate\Support\Facades\Hash;

final class PasswordHashCast implements Castable
{
    /**
     * Cast the given value to a hashed password.
     *
     * @param string $property
     * @param mixed $value
     * 
     * @return string|null
     */
    public function cast(string $property, mixed $value): ?string
    {
        if (!is_string(value: $value)) {
            return null;
        }

        return Hash::make(value: $value);
    }
}
