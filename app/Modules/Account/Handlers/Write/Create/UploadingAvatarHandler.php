<?php declare(strict_types=1);

namespace App\Modules\Account\Handlers\Write\Create;

use App\Shared\Handler;
use App\Modules\Account\Commands\CreateAccountCommand;

final class UploadingAvatarHandler extends Handler
{
    public function handle(
        CreateAccountCommand $command,
        \Closure $next): mixed
    {
        if (!empty($command->avatar)) {
            $avatar = $command->avatar->store(
                path: 'avatars/' . date(format: 'Y-m-d'),
                options: ['disk' => 'public']
            );

            $command->filePath = $avatar;
        }

        if (!$command->filePath) {
            $command->filePath = null;
        }

        return $next($command);
    }
}
