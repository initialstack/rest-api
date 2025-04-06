<?php declare(strict_types=1);

namespace App\Modules\Account\Handlers\Write\Delete;

use App\Shared\Handler;
use App\Contracts\Interface\Repositories\MediaRepositoryInterface;
use App\Modules\Account\Commands\DeleteAccountCommand;

final class DeletingMediaFromDbHandler extends Handler
{
    public function __construct(
        private MediaRepositoryInterface $mediaRepository
    ) {}

    public function handle(
        DeleteAccountCommand $command, \Closure $next): mixed
    {
        try {
            $getMedia = $this->mediaRepository->findByEntityId(
                entityId: $command->id->toString()
            );

            if ($getMedia) {
                foreach ($getMedia as $media) {
                    $this->mediaRepository->remove(media: $media);
                }
            }

            return true;
        } catch (\Throwable $e) {
            return false;
        }
    }
}
