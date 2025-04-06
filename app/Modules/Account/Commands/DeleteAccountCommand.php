<?php declare(strict_types=1);

namespace App\Modules\Account\Commands;

use App\Shared\Command;
use Ramsey\Uuid\UuidInterface;
use WendellAdriel\ValidatedDTO\Attributes\Cast;
use App\DtoCasts\UuidCast;

#[\AllowDynamicProperties]
final class DeleteAccountCommand extends Command
{
    /**
     * ID of the user to be deleted.
     */
    #[Cast(type: UuidCast::class, param: null)]
    public UuidInterface $id;
}
