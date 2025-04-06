<?php declare(strict_types=1);

namespace App\Modules\Account\Handlers\Write\Update;

use App\Shared\Handler;
use App\Contracts\Interface\Repositories\MediaRepositoryInterface;
use App\Modules\Account\Commands\UpdateAccountCommand;
use Illuminate\Support\Facades\Storage;

final class UpdatingAvatarOnDiskHandler extends Handler
{
    public function __construct(
        private MediaRepositoryInterface $mediaRepository
    ) {}

    public function handle(
        UpdateAccountCommand $command, \Closure $next): mixed
    {
        $media = $this->mediaRepository->findByEntityId(
            entityId: $command->id->toString()
        );

        if ($media) {
            $filePath = $media[0]->getFilePath();

            if ($command->avatar && Storage::exists(path: $filePath)) {
                Storage::delete(paths: $filePath);
            }
        }

        if ($command->avatar) {
            $filePath = $command->avatar->store(
                path: 'avatars/' . date(format: 'Y-m-d'),
                options: ['disk' => 'public']
            );
        } elseif ($media) {
            $filePath = $media[0]->getFilePath();
        }

        $command->filePath = $filePath;

        return $next($command);
    }
}
