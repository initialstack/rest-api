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
     * @return array
     */
    public function rules(): array
    {
        return [];
    }

    /**
     * Specifies default values for the command.
     *
     * @return array
     */
    public function defaults(): array
    {
        return [];
    }

    /**
     * Defines data type casts for the command.
     *
     * @return array
     */
    protected function casts(): array
    {
        return [];
    }
}
