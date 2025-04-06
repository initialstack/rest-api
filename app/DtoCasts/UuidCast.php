<?php declare(strict_types=1);

namespace App\DtoCasts;

use WendellAdriel\ValidatedDTO\Casting\Castable;
use Ramsey\Uuid\{Uuid, UuidInterface};
use Ramsey\Uuid\Exception\InvalidUuidStringException;

final class UuidCast implements Castable
{
    /**
     * Cast the given value to a Ramsey\Uuid\UuidInterface object.
     *
     * @param string $property
     * @param mixed $value
     * 
     * @return UuidInterface|null
     */
    public function cast(string $property, mixed $value): ?UuidInterface
    {
        if (!is_string(value: $value)) {
            return null;
        }

        try {
            return Uuid::fromString(uuid: $value);
        }

        catch (InvalidUuidStringException $e) {
            return null;
        }
    }
}
