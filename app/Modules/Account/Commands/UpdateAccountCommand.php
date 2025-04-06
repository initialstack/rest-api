<?php declare(strict_types=1);

namespace App\Modules\Account\Commands;

use App\Shared\Command;
use App\DtoCasts\PasswordHashCast;
use WendellAdriel\ValidatedDTO\Casting\StringCast;
use App\DtoCasts\MediaCast;
use WendellAdriel\ValidatedDTO\Casting\BooleanCast;
use Ramsey\Uuid\UuidInterface;
use WendellAdriel\ValidatedDTO\Attributes\Cast;
use Illuminate\Http\UploadedFile;
use App\DtoCasts\UuidCast;

#[\AllowDynamicProperties]
final class UpdateAccountCommand extends Command
{
    /**
     * ID of the user to be updated.
     */
    #[Cast(type: UuidCast::class, param: null)]
    public UuidInterface $id;

    /**
     * User's avatar file.
     */
    #[Cast(type: MediaCast::class, param: null)]
    public ?UploadedFile $avatar = null;

    /**
     * User's first name.
     */
    #[Cast(type: StringCast::class, param: null)]
    public string $firstName;

    /**
     * User's last name.
     */
    #[Cast(type: StringCast::class, param: null)]
    public string $lastName;

    /**
     * User's patronymic (middle name).
     */
    #[Cast(type: StringCast::class, param: null)]
    public ?string $patronymic = null;

    /**
     * User's phone number.
     */
    #[Cast(type: StringCast::class, param: null)]
    public ?string $phone = null;

    /**
     * User's email address.
     */
    #[Cast(type: StringCast::class, param: null)]
    public string $email;

    /**
     * User's password (will be hashed).
     */
    #[Cast(type: PasswordHashCast::class, param: null)]
    public string $password;

    /**
     * User's status (active/inactive).
     */
    #[Cast(type: BooleanCast::class, param: null)]
    public ?bool $status = null;

    /**
     * ID of the user's role.
     */
    #[Cast(type: UuidCast::class, param: null)]
    public ?UuidInterface $roleId = null;

    /**
     * Maps command properties to their corresponding data keys.
     *
     * @return array
     */
    protected function mapData(): array
    {
        return [
            'first_name' => 'firstName',
            'last_name' => 'lastName',
            'role_id' => 'roleId',
        ];
    }
}
