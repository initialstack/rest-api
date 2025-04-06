<?php declare(strict_types=1);

namespace App\Modules\Auth\Commands;

use App\Shared\Command;
use WendellAdriel\ValidatedDTO\Attributes\Cast;
use WendellAdriel\ValidatedDTO\Casting\StringCast;
use App\DtoCasts\PasswordHashCast;

final class RegisterCommand extends Command
{
    /**
     * The first name of the user.
     *
     * @var string
     */
    #[Cast(type: StringCast::class, param: null)]
    public string $firstName;

    /**
     * The last name of the user.
     *
     * @var string
     */
    #[Cast(type: StringCast::class, param: null)]
    public string $lastName;

    /**
     * The email address of the user.
     *
     * @var string
     */
    #[Cast(type: StringCast::class, param: null)]
    public string $email;

    /**
     * The password for the user, which will be hashed.
     *
     * @var string
     */
    #[Cast(type: PasswordHashCast::class, param: null)]
    public string $password;

    /**
     * Maps the command properties to their corresponding data keys.
     *
     * @return array
     */
    protected function mapData(): array
    {
        return [
            'first_name' => 'firstName',
            'last_name' => 'lastName',
        ];
    }
}
