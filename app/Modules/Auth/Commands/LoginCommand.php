<?php declare(strict_types=1);

namespace App\Modules\Auth\Commands;

use App\Shared\Command;
use WendellAdriel\ValidatedDTO\Casting\StringCast;
use WendellAdriel\ValidatedDTO\Attributes\Cast;

final class LoginCommand extends Command
{
    /**
     * The email address of the user.
     *
     * @var string
     */
    #[Cast(type: StringCast::class, param: null)]
    public string $email;

    /**
     * The password for the user.
     *
     * @var string
     */
    #[Cast(type: StringCast::class, param: null)]
    public string $password;
}
