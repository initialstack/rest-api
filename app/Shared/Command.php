<?php declare(strict_types=1);

namespace App\Shared;

use WendellAdriel\ValidatedDTO\SimpleDTO;
use WendellAdriel\ValidatedDTO\Concerns\EmptyCasts;

abstract class Command extends SimpleDTO
{
    use EmptyCasts;

    /**
     * Defines validation rules for the command.
     *
     * @return array Validation rules.
     */
    public function rules(): array
    {
        return [];
    }

    /**
     * Specifies default values for the command.
     *
     * @return array Default values.
     */
    public function defaults(): array
    {
        return [];
    }

    /**
     * Defines data type casts for the command.
     *
     * @return array Data type casts.
     */
    protected function casts(): array
    {
        return [];
    }
}
